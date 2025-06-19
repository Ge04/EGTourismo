
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap components
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 70,
                    behavior: 'smooth'
                });
            }
        });
    });
    
   
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled', 'shadow-sm');
            } else {
                navbar.classList.remove('navbar-scrolled', 'shadow-sm');
            }
        });
    }
    

    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    
    function checkIfInView() {
        const windowHeight = window.innerHeight;
        const windowTopPosition = window.scrollY;
        const windowBottomPosition = windowTopPosition + windowHeight;
        
        animatedElements.forEach(element => {
            const elementHeight = element.offsetHeight;
            const elementTopPosition = element.offsetTop;
            const elementBottomPosition = elementTopPosition + elementHeight;
            
     
            if (
                (elementBottomPosition >= windowTopPosition) &&
                (elementTopPosition <= windowBottomPosition)
            ) {
                element.classList.add('animated');
            }
        });
    }
    
    window.addEventListener('scroll', checkIfInView);
    window.addEventListener('resize', checkIfInView);
    window.dispatchEvent(new Event('scroll'));
    
    const galleryImages = document.querySelectorAll('.gallery-image');
    
    galleryImages.forEach(image => {
        image.addEventListener('click', function() {
            const imageUrl = this.getAttribute('src');
            const imageAlt = this.getAttribute('alt');
            
            const modal = document.createElement('div');
            modal.classList.add('image-modal');
            
            const modalContent = document.createElement('div');
            modalContent.classList.add('image-modal-content');
            
            const closeBtn = document.createElement('span');
            closeBtn.classList.add('image-modal-close');
            closeBtn.innerHTML = '&times;';
            
            const img = document.createElement('img');
            img.src = imageUrl;
            img.alt = imageAlt;
            
            const caption = document.createElement('p');
            caption.classList.add('image-modal-caption');
            caption.textContent = imageAlt;
            
            modalContent.appendChild(closeBtn);
            modalContent.appendChild(img);
            modalContent.appendChild(caption);
            modal.appendChild(modalContent);
            
            document.body.appendChild(modal);
            
            document.body.style.overflow = 'hidden';
            
            closeBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
            
            function closeModal() {
                document.body.removeChild(modal);
                document.body.style.overflow = '';
            }
        });
    });
    
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            let valid = true;
            const requiredFields = contactForm.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('is-invalid');
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            const emailField = contactForm.querySelector('input[type="email"]');
            if (emailField && emailField.value.trim()) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(emailField.value.trim())) {
                    valid = false;
                    emailField.classList.add('is-invalid');
                }
            }
            
            if (valid) {
                const formContainer = contactForm.parentElement;
                
                const successMessage = document.createElement('div');
                successMessage.classList.add('alert', 'alert-success', 'mt-3');
                successMessage.textContent = '¡Gracias por contactarnos! Nos pondremos en contacto contigo pronto.';
                
                formContainer.appendChild(successMessage);
                contactForm.reset();
                
                setTimeout(() => {
                    formContainer.removeChild(successMessage);
                }, 5000);
            }       
        });
    }
});
