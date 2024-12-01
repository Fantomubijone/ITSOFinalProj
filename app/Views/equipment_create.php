<?= view('adminheader') ?>
<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-right: 20px">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Add New Equipment</h1>

                <div class="profile">
                    <i class="fa-solid fa-user"></i>
                    <div class="profile-info">
                        <p class="name"><?= $first_name ?> <?= $last_name ?></p>
                        <p class="email"><?= $email ?></p>
                    </div>
                </div>
            </div>
            <div class="form-container">
                <form action="<?= base_url('equipment_management/store') ?>" method="post">
                    <div class="form-group">
                        <label for="name">Select Item</label>
                        <select id="name" name="name" class="form-control" onchange="populateFormFields(this.value)" required>
                            <option value="" disabled selected>Select Item Type</option>
                            <option value="Laptop">Laptop</option>
                            <option value="Projector">Projector</option>
                            <option value="HDMI Cable">HDMI Cable</option>
                            <option value="VGA Cable">VGA Cable</option>
                            <option value="Projector Remote">Projector Remote</option>
                            <option value="Keyboard">Keyboard and Mouse (with lightning cable)</option>
                            <option value="Wacom Tablet">Wacom Tablet (with its pen)</option>
                            <option value="Speaker Set">Speaker Set</option>
                            <option value="Webcam">Webcam</option>
                            <option value="Extension Cord">Extension Cord</option>
                            <option value="Cable Crimping Tool">Cable Crimping Tool</option>
                            <option value="Cable Tester">Cable Tester</option>
                            <option value="Lab Room Key">Lab Room Key</option>
                        </select>
                    </div>
                    
                    <div id="dynamicFields"></div>

                    <button type="submit" class="btn btn-primary">Add Equipment</button>
                </form>
            </div>
        </main>
    </div>
</div>

<style>
body, html {
    margin: 0;
    padding: 0;
    font-family: 'Roboto', sans-serif;
}

.form-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    font-weight: bold;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
    transition: border 0.2s ease-in-out;
}

.form-control:focus {
    border-color: #00796b;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

.btn-primary {
    background-color: #00796b;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
}

.btn-primary:hover {
    background-color: #005b4e;
}

h1.h2 {
    color: #00796b;
}

.dynamic-item-container {
    background: #f9f9f9;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.item-header h3 {
    color: #00796b;
    font-weight: bold;
    margin-bottom: 15px;
    text-transform: uppercase;
}

.form-row {
    /* display: flex; */
    gap: 20px;
    flex-wrap: wrap;
}

.form-group {
    flex: 1;
    min-width: 250px; /* Ensures smaller fields don't shrink too much */
}

label {
    font-weight: bold;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
    transition: border 0.2s ease-in-out;
}

.form-control:focus {
    border-color: #00796b;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

</style>

<script>
function populateFormFields(item) {
    const dynamicFields = document.getElementById('dynamicFields');
    dynamicFields.innerHTML = ''; // Clear previous fields

    let itemIDPrefix = '';
    switch (item) {
        case 'Laptop':
            itemIDPrefix = 'LPTP';
            break;
        case 'Projector':
            itemIDPrefix = 'PRJCTR';
            break;
        case 'HDMI Cable':
            itemIDPrefix = 'HDMI';
            break;
        case 'VGA Cable':
            itemIDPrefix = 'VGA';
            break;
        case 'Projector Remote':
            itemIDPrefix = 'PRJCTR-RMTE';
            break;
        case 'Keyboard':
            itemIDPrefix = 'KYBRD';
            dynamicFields.innerHTML += generateFieldHtml('Mouse', 'MSE');
            dynamicFields.innerHTML += generateFieldHtml('Lightning Cable', 'LGTNG');
            break;
        case 'Wacom Tablet':
            itemIDPrefix = 'WCMTBLT';
            dynamicFields.innerHTML += generateFieldHtml('Pen', 'PEN');
            break;
        case 'Speaker Set':
            itemIDPrefix = 'SPKR';
            break;
        case 'Webcam':
            itemIDPrefix = 'WBCMS';
            break;
        case 'Extension Cord':
            itemIDPrefix = 'EXCORD';
            break;
        case 'Cable Crimping Tool':
            itemIDPrefix = 'CBLCRIMP';
            break;
        case 'Cable Tester':
            itemIDPrefix = 'CBLTSTR';
            break;
        case 'Lab Room Key':
            itemIDPrefix = 'LABKEY';
            break;
        default:
            itemIDPrefix = 'GEN';
    }

    dynamicFields.innerHTML += generateFieldHtml(item, itemIDPrefix);

    // Fetch the last item ID from the server
    fetchLastItemID(itemIDPrefix);
}

function generateFieldHtml(name, prefix) {
    return `
        <div class="dynamic-item-container">
            <div class="item-header">
                <h3>${name}</h3>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="item_id_${prefix}">Item ID</label>
                    <input type="text" id="item_id_${prefix}" name="item_id[]" class="form-control" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="name_${prefix}">Name</label>
                    <input type="text" id="name_${prefix}" name="name[]" class="form-control" placeholder = "Enter Item Name" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="name_${prefix}">Category</label>
                    <input type="text" id="name_${prefix}" name="category[]" value="${name}" class="form-control" readonly>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="item_count_${prefix}">Quantity</label>
                    <input type="number" id="item_count_${prefix}" name="item_count[]" class="form-control" min="1" value="1" required oninput="updateItemIDs('${prefix}', this.value)">
                </div>
                <div class="form-group col-md-6">
                    <label for="status_${prefix}">Status</label>
                    <select id="status_${prefix}" name="status[]" class="form-control" required>
                        <option value="Stock">Stock</option>
                        <option value="Defective">Defective</option>
                    </select>
                </div>
            </div>
        </div>
    `;
}


function updateItemIDs(prefix, count) {
    const idField = document.getElementById(`item_id_${prefix}`);
    const baseID = idField.dataset.baseId || `${prefix}-001`;
    const baseNumber = parseInt(baseID.split('-')[1]);
    let itemIDs = '';

    for (let i = 0; i < count; i++) {
        itemIDs += `${prefix}-${String(baseNumber + i).padStart(3, '0')}, `;
    }

    // Remove the trailing comma and space
    itemIDs = itemIDs.slice(0, -2);
    idField.value = itemIDs;
}

function fetchLastItemID(prefix) {
    fetch(`<?= base_url('equipment_management/getLastItemID') ?>/${prefix}`)
        .then(response => response.json())
        .then(data => {
            const idField = document.getElementById(`item_id_${prefix}`);
            const lastID = data.lastItemID ? parseInt(data.lastItemID.split('-')[1]) + 1 : 1;
            idField.value = `${prefix}-${String(lastID).padStart(3, '0')}`;
            idField.dataset.baseId = idField.value;
        })
        
        .catch(error => {
            console.error('Error fetching last item ID:', error);
        });
}
</script>

</body>
</html>
