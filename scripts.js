// ====== MENU MOBILE (Responsive) ======
const navToggle = document.querySelector('.nav-toggle');
const navLinks = document.querySelectorAll('nav ul li');

// Créer un bouton menu mobile (si non présent en HTML)
const menuToggle = document.createElement('div');
menuToggle.classList.add('nav-toggle');
menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
document.querySelector('nav .container').appendChild(menuToggle);

menuToggle.addEventListener('click', () => {
    document.querySelector('nav ul').classList.toggle('active');
});

// Fermer le menu après clic sur un lien
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        document.querySelector('nav ul').classList.remove('active');
    });
});

// ====== ANIMATION AU SCROLL ======
const animateOnScroll = () => {
    const elements = document.querySelectorAll('.project-card, .skill');
    elements.forEach(element => {
        const elementPosition = element.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.3;

        if (elementPosition < screenPosition) {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }
    });
};

// Initialisation
window.addEventListener('load', () => {
    document.querySelectorAll('.project-card, .skill').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    });
    animateOnScroll();
});

window.addEventListener('scroll', animateOnScroll);

// ====== FILTRE DE PROJETS (Optionnel) ======
const filterButtons = document.querySelectorAll('.filter-btn');

if (filterButtons.length > 0) {
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const filter = button.getAttribute('data-filter');
            const projects = document.querySelectorAll('.project-card');

            projects.forEach(project => {
                if (filter === 'all' || project.classList.contains(filter)) {
                    project.style.display = 'block';
                } else {
                    project.style.display = 'none';
                }
            });

            // Mettre à jour le bouton actif
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
        });
    });
}

// ====== CHANGEMENT DE THÈME (Clair/Sombre) ======
const themeToggle = document.querySelector('.theme-toggle');
if (themeToggle) {
    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle('light-mode');
        localStorage.setItem('theme', document.body.classList.contains('light-mode') ? 'light' : 'dark');
    });

    // Vérifier le thème sauvegardé
    if (localStorage.getItem('theme') === 'light') {
        document.body.classList.add('light-mode');
    }
}

// ====== EFFET DE TYPING (Pour la section Hero) ======
const typedText = document.querySelector('.typed-text');
if (typedText) {
    const texts = [,"Marzak Hiba","Stagiaire en Developpement Digital" ];
    let count = 0;
    let index = 0;
    let currentText = '';
    let letter = '';

    (function type() {
        if (count === texts.length) count = 0;
        currentText = texts[count];
        letter = currentText.slice(0, ++index);

        typedText.textContent = letter;
        if (letter.length === currentText.length) {
            count++;
            index = 0;
            setTimeout(type, 2000);
        } else {
            setTimeout(type, 100);
        }
    })();
}