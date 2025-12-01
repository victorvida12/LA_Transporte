const relatorios = [
  { codigo: 1, carregamento: "Fazenda 1", dataCarregamento: "2025-09-02", entrega: "Fazenda 1", dataEntrega: "2025-09-02", motorista: "Motorista 1", metragem: "65M", descricao: "--", carga: "Café", selected: false },
  { codigo: 2, carregamento: "Fazenda 2", dataCarregamento: "2025-09-03", entrega: "Fazenda 2", dataEntrega: "2025-09-03", motorista: "Motorista 2", metragem: "70M", descricao: "--", carga: "Milho", selected: false }
];

let editIndexRelatorio = null;

function renderTabelaRelatorio() {
  const tbody = document.getElementById('relatorio-table-body');
  tbody.innerHTML = '';
  const fCodigo = document.getElementById('filterCodigo').value.trim().toLowerCase();
  const fMotorista = document.getElementById('filterMotorista').value.trim().toLowerCase();
  const fCarregamento = document.getElementById('filterCarregamento').value.trim().toLowerCase();
  const fEntrega = document.getElementById('filterEntrega').value.trim().toLowerCase();
  const fData = document.getElementById('filterData').value;

  relatorios.filter(rel => {
    return (
      (!fCodigo || String(rel.codigo).includes(fCodigo)) &&
      (!fMotorista || rel.motorista.toLowerCase().includes(fMotorista)) &&
      (!fCarregamento || rel.carregamento.toLowerCase().includes(fCarregamento)) &&
      (!fEntrega || rel.entrega.toLowerCase().includes(fEntrega)) &&
      (!fData || rel.dataCarregamento === fData || rel.dataEntrega === fData)
    );
  }).forEach((rel, idx) => {
    if (editIndexRelatorio === idx) {
      tbody.innerHTML += `
        <tr>
          <td><input type="checkbox" ${rel.selected ? "checked" : ""} onclick="toggleRow(${idx})" /></td>
          <td><input type="text" id="editCodigo" value="${rel.codigo}" class="rel-edit-input" style="max-width:60px;" /></td>
          <td><input type="text" id="editCarregamento" value="${rel.carregamento}" class="rel-edit-input" /></td>
          <td><input type="date" id="editDataCarregamento" value="${rel.dataCarregamento}" class="rel-edit-input" /></td>
          <td><input type="text" id="editEntrega" value="${rel.entrega}" class="rel-edit-input" /></td>
          <td><input type="date" id="editDataEntrega" value="${rel.dataEntrega}" class="rel-edit-input" /></td>
          <td><input type="text" id="editMotorista" value="${rel.motorista}" class="rel-edit-input" /></td>
          <td><input type="text" id="editMetragem" value="${rel.metragem}" class="rel-edit-input" /></td>
          <td><input type="text" id="editDescricao" value="${rel.descricao}" class="rel-edit-input desc" /></td>
          <td>
            <button onclick="salvarEdicaoRelatorio(${idx})" title="Salvar">💾</button>
            <button onclick="cancelarEdicaoRelatorio()" title="Cancelar">❌</button>
          </td>
        </tr>
      `;
    } else {
      tbody.innerHTML += `
        <tr>
          <td><input type="checkbox" ${rel.selected ? "checked" : ""} onclick="toggleRow(${idx})" /></td>
          <td>${rel.codigo}</td>
          <td>${rel.carregamento}</td>
          <td>${rel.dataCarregamento}</td>
          <td>${rel.entrega}</td>
          <td>${rel.dataEntrega}</td>
          <td>${rel.motorista}</td>
          <td>${rel.metragem}</td>
          <td>${rel.descricao}</td>
          <td>
            <button onclick="editarRelatorio(${idx})" title="Editar">✏️</button>
            <button onclick="removerRelatorio(${idx})" title="Excluir">❌</button>
          </td>
        </tr>
      `;
    }
  });
}

function toggleRow(idx) {
  relatorios[idx].selected = !relatorios[idx].selected;
}

function toggleSelectAll() {
  const checked = document.getElementById('selectAll').checked;
  relatorios.forEach(r => r.selected = checked);
  renderTabelaRelatorio();
}

function editarRelatorio(idx) {
  editIndexRelatorio = idx;
  renderTabelaRelatorio();
}

function salvarEdicaoRelatorio(idx) {
  relatorios[idx] = {
    codigo: document.getElementById('editCodigo').value,
    carregamento: document.getElementById('editCarregamento').value,
    dataCarregamento: document.getElementById('editDataCarregamento').value,
    entrega: document.getElementById('editEntrega').value,
    dataEntrega: document.getElementById('editDataEntrega').value,
    motorista: document.getElementById('editMotorista').value,
    metragem: document.getElementById('editMetragem').value,
    descricao: document.getElementById('editDescricao').value,
    selected: relatorios[idx].selected
  };
  editIndexRelatorio = null;
  renderTabelaRelatorio();
}

function cancelarEdicaoRelatorio() {
  editIndexRelatorio = null;
  renderTabelaRelatorio();
}

function addRelatorio() {
  relatorios.push({
    codigo: relatorios.length + 1,
    carregamento: document.getElementById('newCarregamento').value,
    dataCarregamento: document.getElementById('newDataCarregamento').value,
    entrega: document.getElementById('newEntrega').value,
    dataEntrega: document.getElementById('newDataEntrega').value,
    carga: document.getElementById('newCarga').value,
    motorista: document.getElementById('newMotorista').value,
    metragem: document.getElementById('newMetragem').value,
    descricao: document.getElementById('newDescricao').value,
    selected: false
  });
  renderTabelaRelatorio();
  document.querySelector('.form-add').reset();
}

function removerRelatorio(idx) {
  relatorios.splice(idx, 1);
  renderTabelaRelatorio();
}

function saveChanges() {
  alert('Funcionalidade de salvar pode ser conectada ao backend.');
}

// Exportação
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
  const imgProps = doc.getImageProperties(imgData);
  const pdfWidth = doc.internal.pageSize.getWidth() - 20;
  const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
  doc.addImage(imgData, 'PNG', 10, 10, pdfWidth, pdfHeight);
  doc.save('relatorio_viagens.pdf');
}

// Exportar Excel
function exportToExcel() {
  const fCodigo = document.getElementById('filterCodigo').value.trim().toLowerCase();
  const fMotorista = document.getElementById('filterMotorista').value.trim().toLowerCase();
  const fCarregamento = document.getElementById('filterCarregamento').value.trim().toLowerCase();
  const fEntrega = document.getElementById('filterEntrega').value.trim().toLowerCase();
  const fData = document.getElementById('filterData').value;

  const dadosFiltrados = relatorios.filter(rel => {
    return (
      (!fCodigo || String(rel.codigo).includes(fCodigo)) &&
      (!fMotorista || rel.motorista.toLowerCase().includes(fMotorista)) &&
      (!fCarregamento || rel.carregamento.toLowerCase().includes(fCarregamento)) &&
      (!fEntrega || rel.entrega.toLowerCase().includes(fEntrega)) &&
      (!fData || rel.dataCarregamento === fData || rel.dataEntrega === fData)
    );
  });
  const ws = XLSX.utils.json_to_sheet(dadosFiltrados);
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "Relatório");
  XLSX.writeFile(wb, "relatorio_viagens.xlsx");
}

// Filtros automáticos
document.getElementById('filterCodigo').addEventListener('input', renderTabelaRelatorio);
document.getElementById('filterMotorista').addEventListener('input', renderTabelaRelatorio);
document.getElementById('filterCarregamento').addEventListener('input', renderTabelaRelatorio);
document.getElementById('filterEntrega').addEventListener('input', renderTabelaRelatorio);
document.getElementById('filterData').addEventListener('change', renderTabelaRelatorio);

window.onload = renderTabelaRelatorio;
