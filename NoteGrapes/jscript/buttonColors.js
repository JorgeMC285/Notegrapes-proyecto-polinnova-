const temas = ['o01', 'o02', 'o03', 'o04', 'o05', 'c01'];
const root = document.documentElement;

function cambiarColores(col) {
    if (!col) return;
    root.classList.remove(...temas);
    root.classList.add(col);
    localStorage.setItem("tema", col);
}
