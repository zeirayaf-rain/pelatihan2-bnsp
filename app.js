document.querySelectorAll('[data-confirm]').forEach(el=>el.addEventListener('click',e=>{if(!confirm(el.dataset.confirm))e.preventDefault()}));
document.querySelectorAll('.alert').forEach(el=>setTimeout(()=>el.classList.add('fade'),5000));
