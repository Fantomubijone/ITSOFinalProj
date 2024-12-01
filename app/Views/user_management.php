<?= view('adminheader') ?>
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-right: 20px">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">User Management</h1>
                <?= view('accounttop') ?>

            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="<?= base_url('user_management/create') ?>" class="btn btn-primary">Add New User</a>
            </div>

            <div id="userTableContainer" style = "margin: auto">
                <table class="table table-striped" style = "margin: auto;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>School ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="userTableBody" style = "margin: auto">
                        <!-- Rows will be dynamically generated -->
                    </tbody>
                </table>
            </div>

            <nav aria-label="Page navigation" id="paginationNav">
                <ul id="pagination" class="pagination" style = "justify-content: left"></ul>
            </nav>
        </main>
    </div>
</div>

<script>
const users = <?= json_encode($users) ?>; // Users data from server
let currentPage = 1;
const itemsPerPage = 8; // Number of items per page

function generateTableRows(data) {
    const tableBody = document.getElementById('userTableBody');
    tableBody.innerHTML = ''; // Clear the table body

    data.forEach(user => {
        const actionButton = user.status == 1 
            ? `<a href="<?= base_url('user_management/deactivate/') ?>${user.id}" class="btn btn-danger btn-sm">Deactivate</a>` 
            : `<a href="<?= base_url('user_management/activate/') ?>${user.id}" class="btn btn-success btn-sm">Activate</a>`;

        const row = `
            <tr>
                <td>${user.id}</td>
                <td>${user.school_id}</td>
                <td>${user.first_name} ${user.last_name}</td>
                <td>${user.email}</td>
                <td>${user.user_type}</td>
                <td>${(user.status == 1) ? 'Active' : 'Deactivated'}</td>
                <td class="action-buttons" style="white-space: nowrap; word-wrap: normal; word-break: normal;">
                    <a href="<?= base_url('user_management/edit/') ?>${user.id}" class="btn btn-warning btn-sm">Edit</a>
                    ${actionButton}
                </td>
            </tr>
        `;
        tableBody.innerHTML += row;
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

    // Add "<<", "<" buttons
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

    // Add ">", ">>" buttons
    if (currentPage < totalPages) {
        pagination.appendChild(createPageItem(currentPage + 1, '>'));
        pagination.appendChild(createPageItem(totalPages, '>>'));
    }
}

function goToPage(page) {
    const totalPages = Math.ceil(users.length / itemsPerPage);
    if (page < 1 || page > totalPages || page === null) return;

    currentPage = page;
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    generateTableRows(users.slice(startIndex, endIndex));
    generatePagination(users.length);
}

// Initialize table and pagination
document.addEventListener('DOMContentLoaded', () => {
    goToPage(1); // Display the first page by default
});
</script>

<?= view('colapse') ?>
</body>
</html>