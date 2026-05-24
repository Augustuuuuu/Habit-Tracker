setTimeout(() => {
  const toast = document.getElementById('toast');

  if (toast) {
    toast.classList.add('opacity-0', 'translate-x-5');

    setTimeout(() => {
      toast.remove();
    }, 500);
  }
}, 3000);
