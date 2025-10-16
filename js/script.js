const tbody = document.querySelector("#inventoryTable tbody");
const searchBox = document.getElementById("searchBox");

// Load all rows from DB
function loadTable() {
  fetch("fetch.php")
    .then(res => res.json())
    .then(data => {
      tbody.innerHTML = "";
      data.forEach(row => addRow(row));
    });
}

// Create a table row
function addRow(row) {
  const tr = document.createElement("tr");
  Object.keys(row).forEach(key => {
    if (key === "id") {
      const td = document.createElement("td");
      td.textContent = row[key];
      tr.appendChild(td);
      return;
    }
    const td = document.createElement("td");
    td.textContent = row[key];
    td.contentEditable = true;
    td.dataset.column = key;
    td.addEventListener("blur", () => updateCell(row.id, key, td.textContent));
    tr.appendChild(td);
  });

  // Actions column
  const actionTd = document.createElement("td");
  const delBtn = document.createElement("button");
  delBtn.textContent = "Delete";
  delBtn.className = "action-btn action-delete";
  delBtn.onclick = () => deleteRow(row.id);

  actionTd.appendChild(delBtn);
  tr.appendChild(actionTd);
  tbody.appendChild(tr);
}

// Update a single cell
function updateCell(id, column, value) {
  fetch("update.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id, column, value })
  }).catch(err => alert("Update failed: " + err));
}

// Delete a row
function deleteRow(id) {
  if (!confirm("Delete this record?")) return;
  fetch(`delete.php?id=${id}`)
    .then(() => loadTable())
    .catch(err => alert("Delete failed: " + err));
}

// Simple search/filter
searchBox.addEventListener("keyup", () => {
  const term = searchBox.value.toLowerCase();
  tbody.querySelectorAll("tr").forEach(tr => {
    const visible = [...tr.children]
      .some(td => td.textContent.toLowerCase().includes(term));
    tr.style.display = visible ? "" : "none";
  });
});

// Export to Excel
document.getElementById("excelBtn").addEventListener("click", () => {
  const table = document.getElementById("inventoryTable");
  const wb = XLSX.utils.table_to_book(table, { sheet: "Inventory" });
  XLSX.writeFile(wb, "lab_inventory.xlsx");
});

loadTable();

// Save theme
localStorage.setItem('theme', 'dark');

// Load theme on page load
const savedTheme = localStorage.getItem('theme');
if (savedTheme === 'dark') {
  document.body.classList.add('dark-theme');
}