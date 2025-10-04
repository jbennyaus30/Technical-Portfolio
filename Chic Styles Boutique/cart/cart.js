function onRemoveFromCartClicked(productID, sizeID) {
    fetch("remove_from_cart.php?" + productID + "&" + sizeID).then(function(response) {
        return response.text();
    }).then(function(data) {
        window.location.href = window.location.href;
    });
}

function onUpdateItemAmountInCart(productID, sizeID, newAmount) {
    fetch("update_item_amount.php?" + productID + "&" + sizeID + "&" + newAmount).then(function(response) {
        return response.text();
    }).then(function(data) {
        window.location.href = window.location.href;
    });
}