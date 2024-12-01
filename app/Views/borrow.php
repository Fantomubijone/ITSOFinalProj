<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Items</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/442b633764.js" crossorigin="anonymous"></script>
    <?= view('style') ?>

    <style>
        .item-list, .selected-list {
            width: 45%;
            background: white;
            padding: 1.5em;
            border-radius: 0.5em;
            box-shadow: 0 0.5em 1em rgba(0, 0, 0, 0.1);
        }

        .item-list .form-label, 
        .selected-list h4 {
            margin-bottom: 0.5em;
            font-weight: 700;
            color: rgb(0, 77, 61); /* Primary color */
        }

        .form-control {
            width: 100%;
            padding: 0.75em;
            margin-bottom: 1em;
            border: 1px solid #ddd;
            border-radius: 0.5em;   
            font-size: 1em;
            background-color: #f1f1f1;
        }

        .list-group {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 20em;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 0.5em;
        }

        .list-group-item {
            padding: 0.75em 1em;
            border-bottom: 1px solid #eee;
            cursor: pointer;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .list-group-item:hover {
            background-color: #e9f5f2; /* Light hover effect */
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 1em;
        }

        .pagination button, .pagination span {
            padding: 0.5em 1em;
            margin: 0 0.5em;
            border: none;
            background-color: rgb(0, 77, 61); /* Primary color */
            color: white;
            font-size: 1em;
            cursor: pointer;
            border-radius: 0.5em;
        }

        .pagination button[disabled] {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .pagination span {
            background-color: white;
            color: rgb(0, 77, 61);
            border: 1px solid rgb(0, 77, 61);
        }

        .pagination span.active {
            background-color: rgb(0, 77, 61);
            color: white;
            font-weight: bold;
        }

        button.btn-primary {
            width: 100%;
            padding: 0.75em;
            background-color: rgb(0, 77, 61); /* Primary color */
            color: white;
            border: none;
            border-radius: 0.5em;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button.btn-primary:hover {
            background-color: rgb(0, 65, 50); /* Darker shade on hover */
        }

        button.btn-primary:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
<?= view('adminheader') ?>
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Student Dashboard</h1>
                <?= view('accounttop') ?>
            </div>
            <div style="display: flex; justify-content: space-between; gap: 2em;">
                <div class="item-list">
                    <label for="searchItem" class="form-label">Search Item</label>
                    <input type="text" class="form-control" id="searchItem" onkeyup="filterItems()" placeholder="Search by name or category...">
                    
                    <label for="itemList" class="form-label">Available Items</label>
                    <ul class="list-group" id="itemList">
                        <!-- Dynamic list of items will be loaded here -->
                    </ul>
                    <div class="pagination" id="pagination">
                        <!-- Pagination buttons will be generated dynamically -->
                    </div>
                </div>
                <div class="selected-list">
                    <h4>Selected Items</h4>
                    <ul class="list-group" id="selectedItems">
                        <!-- Selected items will be added here -->
                    </ul>
                    <button class="btn btn-primary" id="borrowButton" style="margin-top: 20px;" onclick="borrowItems()" disabled>Borrow</button>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    let equipmentData = <?= json_encode($equipment) ?>;
    let selectedItems = [];
    let currentPage = 1;
    const itemsPerPage = 10;

    function filterItems() {
        const searchValue = document.getElementById('searchItem').value.toLowerCase();
        const filteredItems = equipmentData.filter(item =>
            item.name.toLowerCase().includes(searchValue) || item.category.toLowerCase().includes(searchValue)
        );
        renderItems(filteredItems);
    }

    function renderItems(items) {
        const itemList = document.getElementById('itemList');
        itemList.innerHTML = '';
        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const paginatedItems = items.slice(startIndex, endIndex);

        paginatedItems.forEach(item => {
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item';
            listItem.textContent = `${item.item_id} - ${item.name}`;
            listItem.setAttribute('data-item-id', item.item_id);
            listItem.onclick = () => addItemToList(item);
            itemList.appendChild(listItem);
        });

        generatePagination(items.length);
    }

    function generatePagination(totalItems) {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';

        const totalPages = Math.ceil(totalItems / itemsPerPage);

        for (let i = 1; i <= totalPages; i++) {
            const pageSpan = document.createElement('span');
            pageSpan.textContent = i;
            pageSpan.className = i === currentPage ? 'active' : '';
            pageSpan.onclick = () => goToPage(i);
            pagination.appendChild(pageSpan);
        }
    }

    function goToPage(page) {
        currentPage = page;
        filterItems();
    }

    function addItemToList(item) {
        if (!selectedItems.some(selectedItem => selectedItem.item_id === item.item_id)) {
            selectedItems.push(item);
            const selectedList = document.getElementById('selectedItems');
            const listItem = document.createElement('li');
            listItem.className = 'list-group-item';
            listItem.textContent = `${item.item_id} - ${item.name}`;
            listItem.setAttribute('data-item-id', item.item_id);
            selectedList.appendChild(listItem);
            toggleBorrowButton();
        }
    }

    function toggleBorrowButton() {
        const borrowButton = document.getElementById('borrowButton');
        borrowButton.disabled = selectedItems.length === 0;
    }

    function borrowItems() {
        if (selectedItems.length === 0) {
            alert('No selected items.');
            return;
        }

        const borrowDate = new Date().toISOString().split('T')[0];

        const itemsToBorrow = selectedItems.map(item => ({
            item_id: item.item_id,
            name: item.name,
            category: item.category,
            status: item.status,
            borrow_date: borrowDate
        }));

        fetch('<?= base_url('borrow_items') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ items: itemsToBorrow })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Items borrowed successfully!');
                selectedItems = [];
                document.getElementById('selectedItems').innerHTML = '';
                location.reload();
            } else {
                alert('Failed to borrow items.');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', filterItems);
</script>
</body>
</html>
