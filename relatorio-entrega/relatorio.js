let entregas = [];
let editId = null; // agora usamos o ID real, nunca índice

// ====================== CARREGAR DO BANCO ======================
async function carregarEntregas() {
    const resp = await fetch("listar.php");
    entregas = await resp.json();
    renderTabela();
}

// ====================== RENDER TABELA ======================
function renderTabela() {
    const tbody = document.getElementById("entregas-table-body");
    tbody.innerHTML = "";

    const filtroStatus = document.getElementById("filterStatus").value;
    const filtroLocal = document.getElementById("filterLocal").value.trim().toLowerCase();
    const filtroData = document.getElementById("filterData").value;

    const listaFiltrada = entregas.filter(e =>
        (!filtroStatus || e.status === filtroStatus) &&
        (!filtroLocal || e.local.toLowerCase().includes(filtroLocal)) &&
        (!filtroData || e.data === filtroData)
    );

    listaFiltrada.forEach(entrega => {
        if (editId === entrega.id) {
            tbody.innerHTML += `
                <tr>
                    <td></td>
                    <td>${entrega.id}</td>
                    <td><input id="editLocal" class="rel-edit-input" value="${entrega.local}"></td>
                    <td><input id="editData" class="rel-edit-input" type="date" value="${entrega.data}"></td>
                    <td>
                        <select id="editStatus" class="rel-edit-input">
                            <option ${entrega.status === "Concluído" ? "selected" : ""}>Concluído</option>
                            <option ${entrega.status === "Pendente" ? "selected" : ""}>Pendente</option>
                        </select>
                    </td>
                    <td><input id="editDescricao" class="rel-edit-input desc" value="${entrega.descricao}"></td>
                    <td>
                        <button onclick="salvarEdicao(${entrega.id})">💾</button>
                        <button onclick="cancelarEdicao()">❌</button>
                    </td>
                </tr>
            `;
        } else {
            tbody.innerHTML += `
                <tr>
                    <td></td>
                    <td>${entrega.id}</td>
                    <td>${entrega.local}</td>
                    <td>${entrega.data}</td>
                    <td>${entrega.status}</td>
                    <td>${entrega.descricao || "--"}</td>
                    <td>
                        <button onclick="editarEntrega(${entrega.id})">✏️</button>
                        <button onclick="removerEntrega(${entrega.id})">❌</button>
                    </td>
                </tr>
            `;
        }
    });
}

// ====================== ADICIONAR ENTREGA ======================
async function addEntrega() {
    if (editId !== null) {
        alert("Finalize ou cancele a edição antes de adicionar um novo lançamento.");
        return;
    }

    const local = document.getElementById("newLocal").value.trim();
    const data = document.getElementById("newData").value;
    const status = document.getElementById("newStatus").value;
    const descricao = document.getElementById("newDescricao").value.trim();

    if (!local || !data || !status) {
        alert("Preencha todos os campos obrigatórios.");
        return;
    }

    const formData = new FormData();
    formData.append("local", local);
    formData.append("data", data);
    formData.append("status", status);
    formData.append("descricao", descricao);

    await fetch("salvar.php", { method: "POST", body: formData });

    document.querySelector(".form-add").reset();
    carregarEntregas();
}

// ====================== EDIÇÃO ======================
function editarEntrega(id) {
    editId = id;
    renderTabela();
}

async function salvarEdicao(id) {
    const formData = new FormData();
    formData.append("id", id);
    formData.append("local", document.getElementById("editLocal").value);
    formData.append("data", document.getElementById("editData").value);
    formData.append("status", document.getElementById("editStatus").value);
    formData.append("descricao", document.getElementById("editDescricao").value);

    await fetch("atualizar.php", { method: "POST", body: formData });

    editId = null;
    carregarEntregas();
}

function cancelarEdicao() {
    editId = null;
    renderTabela();
}

// ====================== REMOVER ======================
async function removerEntrega(id) {
    if (!confirm("Deseja realmente remover esta entrega?")) return;

    const form = new FormData();
    form.append("id", id);

    await fetch("deletar.php", { method: "POST", body: form });
    carregarEntregas();
}

// ====================== EXPORTAR PDF ======================
async function exportToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    const table = document.querySelector("table");

    const canvas = await html2canvas(table);
    const imgData = canvas.toDataURL("image/png");
    const imgProps = doc.getImageProperties(imgData);
    const pdfWidth = doc.internal.pageSize.getWidth() - 20;
    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

    doc.addImage(imgData, "PNG", 10, 10, pdfWidth, pdfHeight);
    doc.save("relatorio_entregas.pdf");
}

// ====================== EXPORTAR EXCEL ======================
function exportToExcel() {
    const filtroStatus = document.getElementById("filterStatus").value;
    const filtroLocal = document.getElementById("filterLocal").value.trim().toLowerCase();
    const filtroData = document.getElementById("filterData").value;

    const dadosFiltrados = entregas.filter(e =>
        (!filtroStatus || e.status === filtroStatus) &&
        (!filtroLocal || e.local.toLowerCase().includes(filtroLocal)) &&
        (!filtroData || e.data === filtroData)
    );

    const ws = XLSX.utils.json_to_sheet(dadosFiltrados);
    const wb = XLSX.utils.book_new();

    XLSX.utils.book_append_sheet(wb, ws, "Relatório");
    XLSX.writeFile(wb, "relatorio_entregas.xlsx");
}

// ====================== FILTROS ======================
document.getElementById("filterStatus").addEventListener("change", renderTabela);
document.getElementById("filterLocal").addEventListener("input", renderTabela);
document.getElementById("filterData").addEventListener("change", renderTabela);

// ====================== DROPDOWN EXPORTAR ======================
document.getElementById("btnExportar").addEventListener("click", () => {
    const opt = document.getElementById("exportOptions");
    opt.style.display = opt.style.display === "none" ? "block" : "none";
});

// Fecha dropdown se clicar fora
window.addEventListener("click", e => {
    if (!document.getElementById("btnExportar").contains(e.target) &&
        !document.getElementById("exportOptions").contains(e.target)) {
        document.getElementById("exportOptions").style.display = "none";
    }
});

// ====================== INICIAR ======================
window.onload = carregarEntregas;
