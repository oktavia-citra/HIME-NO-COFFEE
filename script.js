// script.js
let cart = [];
let pendingItem = null;
let pendingPrice = 0;

function promptAndAdd(item, price) {
  pendingItem = item;
  pendingPrice = price;
  document.getElementById('modalItem').textContent = item;
  document.getElementById('noteInput').value = '';
  document.getElementById('noteModal').style.display = 'block';
}

function confirmNote() {
  const note = document.getElementById('noteInput').value;
  addToCart(pendingItem, pendingPrice, note);
  closeModal();
}

function closeModal() {
  document.getElementById('noteModal').style.display = 'none';
}

function addToCart(item, price, note = "") {
  cart.push({ item, price, note });
  renderCart();
}

function removeFromCart(index) {
  cart.splice(index, 1);
  renderCart();
}

function renderCart() {
  const cartDiv = document.getElementById('cart');
  const totalSpan = document.getElementById('total');
  cartDiv.innerHTML = '';
  let total = 0;

  cart.forEach((entry, index) => {
    cartDiv.innerHTML += `
      <p>${index + 1}. ${entry.item} - Rp ${entry.price.toLocaleString()}
      ${entry.note ? `(${entry.note})` : ''}
      <button class="remove-btn" onclick="removeFromCart(${index})">Hapus</button></p>
    `;
    total += entry.price;
  });

  totalSpan.textContent = total.toLocaleString();
}

function prepareCheckout() {
  document.getElementById('orderData').value = JSON.stringify(cart);
  return true;
}

function submitWithMethod(method) {
  document.getElementById('method').value = method;
  if (prepareCheckout()) {
    document.querySelector('form').submit();
  }
}

