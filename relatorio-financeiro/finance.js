const financeData = [
  { categoria: "DESPESAS FIXAS", tipo: "Aluguel", valor: 1000, descricao: "" },
  { categoria: "RECEBIMENTOS", tipo: "Adiantamento", valor: 500, descricao: "" },
  { categoria: "DESPESAS VARIÁVEIS", tipo: "Manutenção de veículos", valor: 200, descricao: "" }
];

let editIndexFinance = null;

function renderTabelaFinance() {
  const tbody = document.getElementById('finance-table-body');
  tbody.innerHTML = '';
  const filtroCategoria = document.getElementById('filterCategoria').value;

  financeData
    .filter(f => !filtroCategoria || f.categoria === filtroCategoria)
    .forEach((item, idx) => {
      if (editIndexFinance === idx) {
        tbody.innerHTML += `
        <tr>
          <td>
            <button onclick="salvarEdicaoFinance(${idx})" title="Salvar">💾</button>
            <button onclick="cancelarEdicaoFinance()" title="Cancelar">❌</button>
          </td>
          <td>
            <select id="editCategoria" required>
              <option ${item.categoria === "DESPESAS FIXAS" ? "selected" : ""}>DESPESAS FIXAS</option>
              <option ${item.categoria === "RECEBIMENTOS" ? "selected" : ""}>RECEBIMENTOS</option>
              <option ${item.categoria === "DESPESAS VARIÁVEIS" ? "selected" : ""}>DESPESAS VARIÁVEIS</option>
            </select>
          </td>
          <td><input type="text" id="editTipo" value="${item.tipo}" required/></td>
          <td><input type="number" id="editValor" value="${item.valor}" step="0.01"/></td>
          <td><input type="text" id="editDescricao" value="${item.descricao}"/></td>
        </tr>
        `;
      } else {
        tbody.innerHTML += `
        <tr>
          <td>
            <button onclick="editarFinance(${idx})" title="Editar">✏️</button>
            <button onclick="removerFinance(${idx})" title="Excluir">❌</button>
          </td>
          <td>${item.categoria}</td>
          <td>${item.tipo}</td>
          <td>${item.valor !== undefined ? 'R$ ' + Number(item.valor).toFixed(2) : '--'}</td>
          <td>${item.descricao || '--'}</td>
        </tr>
        `;
      }
    });
}

function editarFinance(idx) {
  editIndexFinance = idx;
  renderTabelaFinance();
}

function salvarEdicaoFinance(idx) {
  financeData[idx] = {
    categoria: document.getElementById('editCategoria').value,
    tipo: document.getElementById('editTipo').value,
    valor: Number(document.getElementById('editValor').value),
    descricao: document.getElementById('editDescricao').value,
  };
  editIndexFinance = null;
  renderTabelaFinance();
}

function cancelarEdicaoFinance() {
  editIndexFinance = null;
  renderTabelaFinance();
}

function addFinanceiro() {
  if (editIndexFinance === null) {
    financeData.push({
      categoria: document.getElementById('newCategoria').value,
      tipo: document.getElementById('newTipo').value,
      valor: Number(document.getElementById('newValor').value),
      descricao: document.getElementById('newDescricao').value
    });
    renderTabelaFinance();
    document.querySelector('.form-add').reset();
  } else {
    alert("Conclua ou cancele a edição antes de adicionar um novo registro.");
  }
}

function removerFinance(idx) {
  financeData.splice(idx, 1);
  editIndexFinance = null;
  renderTabelaFinance();
}

function saveChanges() {
  alert('Funcionalidade de salvar pode ser conectada ao backend.');
}

// Toggle opções exportar
document.getElementById('btnExportar').addEventListener('click', () => {
  const options = document.getElementById('exportOptions');
  options.style.display = options.style.display === 'none' ? 'block' : 'none';
});

window.addEventListener('click', e => {
  if (!document.getElementById('btnExportar').contains(e.target) &&
      !document.getElementById('exportOptions').contains(e.target)) {
    document.getElementById('exportOptions').style.display = 'none';
  }
});

// Exportar PDF
async function exportToPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();

  const table = document.querySelector("table");
  const canvas = await html2canvas(table);
  const imgData = canvas.toDataURL('image/png');
  const imgProps= doc.getImageProperties(imgData);
  const pdfWidth = doc.internal.pageSize.getWidth() - 20;
  const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

  doc.addImage(imgData, 'PNG', 10, 10, pdfWidth, pdfHeight);
  doc.save('relatorio_financeiro.pdf');
}

// Exportar Excel
function exportToExcel() {
  const filtroCategoria = document.getElementById('filterCategoria').value;

  const dadosFiltrados = financeData.filter(f =>
    (!filtroCategoria || f.categoria === filtroCategoria)
  );

  const ws = XLSX.utils.json_to_sheet(dadosFiltrados);
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "Relatório Financeiro");
  XLSX.writeFile(wb, "relatorio_financeiro.xlsx");
}

document.getElementById('filterCategoria').addEventListener('change', renderTabelaFinance);

window.onload = renderTabelaFinance;
