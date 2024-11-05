function setShippingFee(fee) {
    // Update the shipping fee
    document.getElementById("shippingFee").innerText = `$${fee.toFixed(2)}`;
        
    // Calculate and update the total fee
    const subtotal = parseFloat(document.getElementById("subtotalPrice").innerText.replace('$', ''));
    const total = subtotal + fee;
    document.getElementById("totalPrice").innerText = `$${total.toFixed(2)}`;
    document.getElementById("paymentSubmit").value = `Pay $${total.toFixed(2)}`;
}

document.addEventListener("DOMContentLoaded", ()=> {
    const subtotal = parseFloat(document.getElementById("subtotalValue").value);
    console.log(subtotal);
    document.getElementById("subtotalPrice").innerText = subtotal;
    document.getElementById("totalPrice").innerText = subtotal;
})