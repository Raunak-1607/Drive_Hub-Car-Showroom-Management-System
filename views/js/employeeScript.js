var actionButtons = document.querySelectorAll('.action-btn');

for(var i = 0; i < actionButtons.length; i++)
{
    actionButtons[i].addEventListener('click', function()
    {
        var action = this.getAttribute('data-action');
        var id = this.getAttribute('data-id');

        if(action == 'resolve')
        {
            location.href = '../../controllers/inquiryController.php?action=resolve&id=' + id;
        }
        else if(action == 'approve' || action == 'reject')
        {
            location.href = '../../controllers/testDriveController.php?action=' + action + '&id=' + id;
        }
        else if(action == 'sold')
        {
            location.href = '../../controllers/salesController.php?action=sold&id=' + id;
        }
    });
}

function validateNewSaleForm()
{
    let hasErr = false;
    const customer = document.getElementById('saleCustomer').value.trim();
    const vehicle = document.getElementById('saleVehicle').value;
    const salePrice = document.getElementById('salePrice').value;
    const saleDate = document.getElementById('saleDate').value;

    const customerErr = document.getElementById('customerErr');
    const vehicleErr = document.getElementById('vehicleErr');
    const salePriceErr = document.getElementById('salePriceErr');
    const saleDateErr = document.getElementById('saleDateErr');

    customerErr.innerHTML = '';
    vehicleErr.innerHTML = '';
    salePriceErr.innerHTML = '';
    saleDateErr.innerHTML = '';

    if(customer === '')
    {
        customerErr.innerHTML = 'customer name cannot be empty';
        hasErr = true;
    }

    if(vehicle === '')
    {
        vehicleErr.innerHTML = 'vehicle must be selected';
        hasErr = true;
    }

    if(salePrice === '')
    {
        salePriceErr.innerHTML = 'sale price cannot be empty';
        hasErr = true;
    }

    if(saleDate === '')
    {
        saleDateErr.innerHTML = 'sale date must be selected';
        hasErr = true;
    }

    if(!hasErr)
    {
        return true;
    }
    else
    {
        return false;
    }
}
