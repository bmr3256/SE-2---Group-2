function toggleFAQ(element) {
    const answer = element.nextElementSibling;
    const icon = element.querySelector('i');
    const isCurrentlyOpen = answer.classList.contains('show');
    
    // Close all other FAQs
    document.querySelectorAll('.faq-answer').forEach(item => {
        if (item !== answer) {
            item.classList.remove('show');
        }
    });
    
    document.querySelectorAll('.faq-question').forEach(item => {
        if (item !== element) {
            item.classList.remove('active');
            const itemIcon = item.querySelector('i');
            itemIcon.classList.remove('fa-chevron-up');
            itemIcon.classList.add('fa-chevron-down');
        }
    });
    
    // Toggle current FAQ
    if (isCurrentlyOpen) {
        answer.classList.remove('show');
        element.classList.remove('active');
        icon.classList.remove('fa-chevron-up');
        icon.classList.add('fa-chevron-down');
    } else {
        answer.classList.add('show');
        element.classList.add('active');
        icon.classList.remove('fa-chevron-down');
        icon.classList.add('fa-chevron-up');
    }
}