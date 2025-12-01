<?php
require "../config.php";

// LISTAR REGISTROS
$sql = "SELECT * FROM financeiro ORDER BY id DESC";
$result = $conn->query($sql);

$registros = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $registros[] = [
            'id' => $row['id'],
            'tipo' => $row['tipo'],
            'descricao' => $row['descricao'],
            'valor' => $row['valor'],
            'data_lancamento' => $row['data_lancamento'] // manter formato YYYY-MM-DD para JS
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<title>Relatório Financeiro</title>

<link rel="stylesheet" href="../css/financeiro.css" />
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/style2.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<body>

<div class="sidebar d-flex flex-column">
    <div class="sidebar-header">
        <img src="../img/logo-branca.png" class="logo">
        <span>LA Transportes</span>
    </div>

    <nav class="nav flex-column">
        <a class="nav-link" href="../painel.php"><i class="bi bi-house"></i> Painel</a>
        <a class="nav-link" href="../relatorio-entrega/index.php"><i class="bi bi-truck"></i> Entregas</a>
        <a class="nav-link" href="../veiculos.php"><i class="bi bi-car-front"></i> Veículos</a>
        <a class="nav-link active" href="finance.php"><i class="bi bi-currency-dollar"></i> Financeiro</a>
        <a class="nav-link" href="../maquinario.php"><i class="bi bi-tools"></i> Locação</a>
        <a class="nav-link" href="../func.php"><i class="bi bi-people"></i> Funcionários</a>
    </nav>

    <div class="bottom">
        <a class="nav-link" href="#"><i class="bi bi-box-arrow-left"></i> Sair</a>
    </div>
</div>

<div class="main-content">
<div class="box-panel">

<header class="d-flex justify-content-between align-items-center mb-3">
    <h2>Financeiro</h2>
    <div class="btn-group" style="position: relative;">
        <button id="btnExportar" class="btn btn-secondary">Exportar ▼</button>
        <div id="exportOptions" class="export-options" style="display:none;">
            <button onclick="exportToPDF()" class="btn btn-sm btn-outline-dark">Exportar PDF</button>
            <button onclick="exportToExcel()" class="btn btn-sm btn-outline-dark">Exportar Excel</button>
        </div>
    </div>
</header>

<!-- TABELA -->
<table id="finance-table" class="table table-bordered table-striped align-middle">
  <thead class="table-light">
    <tr>
      <th>Ações</th>
      <th>Tipo</th>
      <th>Descrição</th>
      <th>Valor (R$)</th>
      <th>Data</th>
    </tr>
  </thead>
  <tbody id="finance-table-body">
    <!-- Preenchido via JS -->
  </tbody>
</table>

<hr>

<h3>Adicionar Lançamento</h3>
<form class="form-add d-flex flex-wrap" onsubmit="addFinanceiro(); return false;">
  <select id="newTipo" required>
    <option value="">Selecione Tipo</option>
    <option value="Entrada">Entrada</option>
    <option value="Saida">Saída</option>
  </select>

  <input type="text" id="newDescricao" placeholder="Descrição" required>
  <input type="number" id="newValor" placeholder="Valor R$" step="0.01" required>
  <input type="date" id="newData" required>

  <button type="submit" class="btn btn-primary">Adicionar</button>
</form>

</div>
</div>

<script>
  let financeData = <?php echo json_encode($registros); ?>;
  let editIndexFinance = null;

  function formatDateBR(dateStr) {
    if (!dateStr) return '--';
    const d = new Date(dateStr);
    const day = String(d.getDate()).padStart(2,'0');
    const month = String(d.getMonth()+1).padStart(2,'0');
    const year = d.getFullYear();
    return `${day}/${month}/${year}`;
  }

  function renderTabelaFinance() {
    const tbody = document.getElementById('finance-table-body');
    tbody.innerHTML = '';
    financeData.forEach((item, idx) => {
      if(editIndexFinance === idx) {
        tbody.innerHTML += `
          <tr>
            <td>
              <button onclick="salvarEdicaoFinance(${idx})" title="Salvar">💾</button>
              <button onclick="cancelarEdicaoFinance()" title="Cancelar">❌</button>
            </td>
            <td>
              <select id="editTipo" required>
                <option ${item.tipo === 'Entrada' ? 'selected' : ''}>Entrada</option>
                <option ${item.tipo === 'Saida' ? 'selected' : ''}>Saída</option>
              </select>
            </td>
            <td><input type="text" id="editDescricao" value="${item.descricao}" required/></td>
            <td><input type="number" id="editValor" value="${item.valor}" step="0.01"/></td>
            <td><input type="date" id="editData" value="${item.data_lancamento}"/></td>
          </tr>`;
      } else {
        tbody.innerHTML += `
          <tr>
            <td>
              <button onclick="editarFinance(${idx})" title="Editar">✏️</button>
              <button onclick="removerFinance(${item.id})" title="Excluir">❌</button>
            </td>
            <td>${item.tipo}</td>
            <td>${item.descricao}</td>
            <td>R$ ${Number(item.valor).toFixed(2)}</td>
            <td>${formatDateBR(item.data_lancamento)}</td>
          </tr>`;
      }
    });
  }

  function editarFinance(idx) {
    editIndexFinance = idx;
    renderTabelaFinance();
  }

  function salvarEdicaoFinance(idx) {
    const item = financeData[idx];
    const dados = {
      tipo: document.getElementById('editTipo').value,
      descricao: document.getElementById('editDescricao').value,
      valor: Number(document.getElementById('editValor').value),
      data_lancamento: document.getElementById('editData').value
    };

    // Atualiza no backend
    fetch('editar.php', {
      method: 'POST',
      headers: {'Content-Type':'application/json'},
      body: JSON.stringify({id:item.id, ...dados})
    }).then(()=> {
      financeData[idx] = {...item, ...dados};
      editIndexFinance = null;
      renderTabelaFinance();
    });
  }

  function cancelarEdicaoFinance() {
    editIndexFinance = null;
    renderTabelaFinance();
  }

  function removerFinance(id) {
  if(confirm("Deseja realmente excluir este registro?")) {
    fetch(`excluir.php?id=${id}`, { method: 'GET' })
      .then(res => res.json()) // espera a resposta JSON
      .then(res => {
        if(res.success){
          // garante que os tipos sejam iguais
          financeData = financeData.filter(f => parseInt(f.id) !== parseInt(id));
          renderTabelaFinance();
        } else {
          alert("Erro ao excluir registro!");
        }
      })
      .catch(err => {
        console.error(err);
        alert("Erro ao excluir registro!");
      });
  }
}


  function addFinanceiro() {
    const dados = {
      tipo: document.getElementById('newTipo').value,
      descricao: document.getElementById('newDescricao').value,
      valor: Number(document.getElementById('newValor').value),
      data_lancamento: document.getElementById('newData').value
    };

    fetch('adicionar.php', {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify(dados)
    })
    .then(res => res.json())
    .then(res => {
      financeData.unshift({...dados, id: res.id}); // adiciona ao topo
      document.querySelector('.form-add').reset();
      renderTabelaFinance();
    });
  }
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

  // --- Exportar Excel ---
  function exportToExcel() {
    const ws = XLSX.utils.json_to_sheet(financeData);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Relatório Financeiro");
    XLSX.writeFile(wb, "relatorio_financeiro.xlsx");
  }

  // --- Toggle menu Exportar ---
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

  window.onload = renderTabelaFinance;
</script>
<script src="finance.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
</body>
</html>
