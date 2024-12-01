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
        .container-fluid {
            display: flex;
            justify-content: space-between;
        }
        .item-list, .selected-list {
            width: 45%;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .pagination button {
            padding: 5px 10px;
            margin: 0 5px;
            border: none;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border-radius: 5px;
        }
        .pagination button[disabled] {
            background-color: #ccc;
            cursor: not-allowed;
        }
        .list-group-item {
            cursor: pointer;
        }
        .list-group-item:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
<?= view('adminheader') ?>
<div class="container-fluid">
    <div class="item-list">
        <div class="mb-3">
            <label for="searchItem" class="form-label">Search Item</label>
            <input type="text" class="form-control" id="searchItem" onkeyup="filterItems()">
        </div>
        <div class="mb-3">
            <label for="itemList" class="form-label">Available Items</label>
            <ul class="list-group" id="itemList">
                <!-- Dynamic list of items will be loaded here -->
            </ul>
        </div>
        <div class="pagination">
            <button id="prevPage" onclick="prevPage()">Previous</button>
            <button id="nextPage" onclick="nextPage()">Next</button>
        </div>
    </div>
    <div class="selected-list">
        <h4>Selected Items</h4>
        <ul class="list-group" id="selectedItems">
            <!-- Selected items will be added here -->
        </ul>
        <button class="btn btn-primary" style="margin-top: 20px;" onclick="borrowItems()">Borrow</button>
    </div>
</div>

<script>
let equipmentData = <?= json_encode($equipment) ?>;
let selectedItems = [];
let currentPage = 1;
const itemsPerPage = 5;

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
        listItem.textContent = `${item.name} (${item.category})`;
        listItem.setAttribute('data-item-id', item.item_id);
        listItem.onclick = () => addItemToList(item);
        itemList.appendChild(listItem);
    });

    document.getElementById('prevPage').disabled = currentPage === 1;
    document.getElementById('nextPage').disabled = endIndex >= items.length;
}

function addItemToList(item) {
    if (!selectedItems.some(selectedItem => selectedItem.item_id === item.item_id)) {
        selectedItems.push(item);
        const selectedList = document.getElementById('selectedItems');
        const listItem = document.createElement('li');
        listItem.className = 'list-group-item';
        listItem.textContent = `${item.name} (${item.category}) - ${item.item_id}`;
        listItem.setAttribute('data-item-id', item.item_id);
        selectedList.appendChild(listItem);
    }
}

function borrowItems() {
    const borrowDate = new Date().toISOString().split('T')[0]; // Current date

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
            sendEmail(itemsToBorrow);
        } else {
            alert('Failed to borrow items.');
        }
    });
}

function sendEmail(items) {
    fetch('<?= base_url('send_borrow_email') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ items: items })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Email sent successfully!');
        } else {
            alert('Failed to send email.');
        }
    });
}

function prevPage() {
    if (currentPage > 1) {
        currentPage--;
        filterItems();
    }
}

function nextPage() {
    currentPage++;
    filterItems();
}

document.addEventListener('DOMContentLoaded', filterItems);
</script>

</body>
</html>
