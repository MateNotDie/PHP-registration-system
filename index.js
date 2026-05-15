function toggleMenu(){
  document.getElementById("menu").classList.toggle("open");
  document.getElementById("overlay").classList.toggle("active");
  document.querySelector(".menugomb").classList.toggle("active");
}

function closeMenu(){
  document.getElementById("menu").classList.remove("open");
  document.getElementById("overlay").classList.remove("active");
  document.querySelector(".menugomb").classList.remove("active");
}

function getIcon(type) {
  switch(type) {
    case 'success': return 'checkmark-circle';
    case 'warning': return 'alert-circle';
    default: return 'information-circle';
  }
}

window.showToast = function showToast(message, type = 'info') {
  const container = document.getElementById('toastContainer');
  const toast = document.createElement('div');
  toast.classList.add('toast', type);
  toast.innerHTML = `
    <ion-icon name="${getIcon(type)}"></ion-icon>
    <span>${message}</span>
    <ion-icon name="close" class="close"></ion-icon>
  `;
  container.appendChild(toast);
  requestAnimationFrame(() => {
    toast.classList.add('show');
  });
  const removeToast = () => {
    toast.classList.remove('show');
    toast.classList.add('hide');
    setTimeout(() => {
      toast.remove();
    }, 350);
  };
  toast.querySelector('.close').addEventListener('click', removeToast);
  setTimeout(removeToast, 3500);
}

const checkbox = document.getElementById("elfogadas");
const button = document.getElementById("regisztraciogomb");
checkbox.addEventListener("change", () => {
  const isChecked = checkbox.checked;
  button.disabled = !isChecked;
});