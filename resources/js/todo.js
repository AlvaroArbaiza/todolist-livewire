document.addEventListener('DOMContentLoaded', function () {
    const iconTrigger = document.getElementById('icon');
    const deadlineInput = document.getElementById('deadline');
    
    // window.getComputedStyle(elemento): getComputedStyle è una funzione che restituisce l'oggetto CSSStyleDeclaration che rappresenta tutti i valori dei CSS calcolati per un elemento.
    // .getPropertyValue('display'): Utilizziamo il metodo getPropertyValue('display') per ottenere il valore specifico della proprietà CSS "display" per quell'elemento.
    let display = window.getComputedStyle(deadlineInput).getPropertyValue('display')

    iconTrigger.addEventListener('click', function (event) {
        if (display === 'none') {
            // Se l'input è nascosto o non visibile, mostralo
            deadlineInput.style.display = 'block';
            deadlineInput.focus();
            iconTrigger.style.display = 'none'
        } else {
            // Se l'input è visibile, nascondilo
            deadlineInput.style.display = 'none';
        }
    });

    document.addEventListener('click', function (event) {
        if (event.target !== iconTrigger && event.target !== deadlineInput) {
            // Se si fa clic altrove, nascondi l'input
            deadlineInput.style.display = 'none';
            iconTrigger.style.display = 'block'
        }
    });
});