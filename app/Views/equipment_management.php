<?= view('adminheader') ?>
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-right: 20px">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Equipment Management</h1>

                <?= view('accounttop') ?>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3" style = "wdith: auto">
                <a href="<?= base_url('equipment_management/create') ?>" class="btn btn-primary">Add New Equipment</a>
                <div class="btn-group" role="group" aria-label="View Options" style = "margin-top: auto; margin-bottom: auto">
                    <button type="button" class="btn btn-primary" onclick="viewAll()">View All</button>
                    <button type="button" class="btn btn-primary" onclick="viewByItem()">View by Item</button>
                </div>
            </div>

            <table class="table table-striped" id="equipmentTable" style="margin: auto">
                <thead id="tableHead">
                    <!-- Table headers will be updated dynamically -->
                </thead>
                <tbody id="equipmentTableBody">
                    <!-- Equipment rows will be generated dynamically -->
                </tbody>
            </table>

            <nav aria-label="Page navigation" id="paginationNav">
                <ul class="pagination" id="pagination">
                    <!-- Pagination links will be generated dynamically -->
                </ul>
            </nav>
        </main>
    </div>
</div>

<script>
const equipmentData = <?= json_encode($equipment) ?>;
const itemsPerPage = 9;
let currentPage = 1;

function generateTableRows(data) {
    const tableBody = document.getElementById('equipmentTableBody');
    tableBody.innerHTML = '';

    data.forEach((item, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.id}</td>
            <td>${item.item_id}</td>
            <td>${item.name}</td>
            <td>${item.status}</td>
            <td>${item.category}</td>
            <td class="action-buttons" style= "white-space: nowrap; word-wrap: normal; word-break: normal;">
                <a href="<?= base_url('equipment_management/edit/') ?>${item.id}" class="btn btn-warning btn-sm">Edit</a>
                ${item.status === 'Stock' ? `<a href="<?= base_url('equipment_management/deactivate/') ?>${item.id}" class="btn btn-danger btn-sm">Deactivate</a>` : ''}
                ${item.status === 'Defective' ? `<a href="<?= base_url('equipment_management/activate/') ?>${item.id}" class="btn btn-success btn-sm">Activate</a>` : ''}
            </td>
        `;
        tableBody.appendChild(row);
    });
}


function generatePagination(totalItems) {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const pageLimit = 5; // Number of pages to show at a time

    const createPageItem = (page, text, isDisabled = false) => {
        const pageItem = document.createElement('li');
        pageItem.className = 'page-item' + (isDisabled ? ' disabled' : '') + (page === currentPage ? ' active' : '');
        pageItem.innerHTML = `<a class="page-link" href="#" onclick="goToPage(${page})">${text}</a>`;
        return pageItem;
    };

    // Add "<<" and "<" buttons
    if (currentPage > 1) {
        pagination.appendChild(createPageItem(1, '<<'));
        pagination.appendChild(createPageItem(currentPage - 1, '<'));
    }

    // Determine the range of pages to display
    const startPage = Math.max(1, Math.min(currentPage - 2, totalPages - pageLimit + 1));
    const endPage = Math.min(totalPages, startPage + pageLimit - 1);

    for (let i = startPage; i <= endPage; i++) {
        pagination.appendChild(createPageItem(i, i));
    }

    // Add ">" and ">>" buttons
    if (currentPage < totalPages) {
        pagination.appendChild(createPageItem(currentPage + 1, '>'));
        pagination.appendChild(createPageItem(totalPages, '>>'));
    }
}

function goToPage(page) {
    const totalPages = Math.ceil(equipmentData.length / itemsPerPage);
    if (page < 1 || page > totalPages || page === null) return;

    currentPage = page;
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    generateTableRows(equipmentData.slice(startIndex, endIndex));
    generatePagination(equipmentData.length);
}


function viewAll() {
    document.getElementById('paginationNav').style.display = 'flex';
    document.getElementById('tableHead').innerHTML = `
        <tr>
            <th>ID</th>
            <th>Item ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    `;
    generatePagination(equipmentData.length);
    goToPage(1);
}
function viewByItem() {
    document.getElementById('paginationNav').style.display = 'none';
    document.getElementById('tableHead').innerHTML = `
        <tr>
            <th>CATEGORY</th>
            <th>TOTAL ACTIVE</th>
            <th>TOTAL ON STOCK</th>
            <th>TOTAL DEFECTIVE</th>
            <th>TOTAL QTY</th>
            <th>STATUS</th>
        </tr>
    `;

    const groupedData = equipmentData.reduce((acc, item) => {
        if (!acc[item.category]) {
            acc[item.category] = [];
        }
        acc[item.category].push(item);
        return acc;
    }, {});

    const tableBody = document.getElementById('equipmentTableBody');
    tableBody.innerHTML = '';

    Object.keys(groupedData).forEach((category) => {
        const totalQty = groupedData[category].length;
        const activeQty = groupedData[category].filter(item => item.status === 'Active').length;
        const stockQty = groupedData[category].filter(item => item.status === 'Stock').length;
        const defectiveQty = groupedData[category].filter(item => item.status === 'Defective').length;
        const availableQty = activeQty + stockQty;
        const statusText = availableQty > 0 ? 'AVAILABLE' : 'NOT AVAILABLE';
        const statusClass = availableQty > 0 ? 'color: green;' : 'color: red;';

        const groupRow = document.createElement('tr');
        groupRow.className = 'group-header';
        groupRow.innerHTML = `
            <td><b>${category}</b></td>
            <td>${activeQty}</td>
            <td>${stockQty}</td>
            <td>${defectiveQty}</td>
            <td>${totalQty}</td>
            <td style="${statusClass}; font-weight: bold;">${statusText}</td>
        `;
        groupRow.onclick = () => toggleGroup(category.replace(/\s/g, '-'));
        tableBody.appendChild(groupRow);

        const groupDetails = document.createElement('tr');
        groupDetails.id = `group-${category.replace(/\s/g, '-')}`;
        groupDetails.className = 'group-details';
        groupDetails.style.display = 'none';
        groupDetails.innerHTML = `
            <td colspan="6">
                <div class="detail-header">
                    <div>ID</div>
                    <div>Item ID</div>
                    <div>Name</div>
                    <div>Status</div>
                </div>
                ${groupedData[category].map(item => `
                    <div class="detail-row">
                        <div>${item.id}</div>
                        <div>${item.item_id}</div>
                        <div>${item.name}</div>
                        <div style="${item.status === 'Stock' ? 'color: green' : item.status === 'Defective' ? 'color: red' : ''}">${item.status}</div>
                    </div>
                `).join('')}
            </td>
        `;
        tableBody.appendChild(groupDetails);
    });
}

function toggleGroup(groupId) {
    const groupDetails = document.getElementById(`group-${groupId}`);
    groupDetails.style.display = groupDetails.style.display === 'none' ? 'table-row' : 'none';
}

document.addEventListener('DOMContentLoaded', () => {
    viewAll(); // Display all equipment by default
});
</script>

<?= view('colapse') ?>
</body>
</html>