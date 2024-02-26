function compareTitles(a, b) {
    if (a.textContent < b.textContent) {
        return -1;
    } else if (a.textContent > b.textContent) {
        return 1;
    } else {
        return 0;
    }
}

function bubbleSort(arr) {
    let len = arr.length;
    let swapped;
    do {
        swapped = false;
        for (let i = 0; i < len - 1; i++) {
            if (compareTitles(arr[i], arr[i + 1]) > 0) {
                let temp = arr[i];
                arr[i] = arr[i + 1];
                arr[i + 1] = temp;
                swapped = true;
            }
        }
    } while (swapped);
}

function sortTable() {
    const table = document.getElementById("books-table");
    const rows = table.rows;
    const sortedRows = Array.from(rows).slice(1); // Exclude the header row
    bubbleSort(sortedRows);
    const tbody = document.createElement("tbody");
    sortedRows.forEach(row => tbody.appendChild(row));
    table.innerHTML = "<thead><tr><th>Title</th><th>Quantity</th></thead>" + tbody.outerHTML;
}

document.getElementById("sort-button").addEventListener("click", function() {
    sortTable();
});

document.getElementById("search-input").addEventListener("input", function() {
    const searchTerm = this.value.trim();
    const rows = document.querySelectorAll("#books-table tbody tr");
    rows.forEach(row => {
        if (row.textContent.toLowerCase().includes(searchTerm.toLowerCase())) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});