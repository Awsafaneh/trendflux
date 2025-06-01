// script.js
// هذا الكود يتضمن وظائف شريط التنقل المتجاوب، التصغير عند التمرير، والرسوم المتحركة عند التمرير.
// تم إزالة جميع الأكواد المتعلقة بنموذج الاتصال وإرسال الرسائل عبر الإيميل.

// وظيفة تبديل قائمة الجوال (Hamburger menu)
function toggleMobileMenu() {
    const navLinks = document.getElementById('navLinks');
    navLinks.classList.toggle('active');
}

// وظيفة تصغير شريط التنقل عند التمرير لأسفل الصفحة
window.addEventListener('scroll', function() {
    const navbar = document.querySelector('nav');
    // إضافة كلاس 'scrolled' عندما يكون التمرير أكثر من 50 بكسل
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        // إزالة الكلاس عندما يعود المستخدم لأعلى الصفحة
        navbar.classList.remove('scrolled');
    }
});

// إغلاق قائمة الجوال عند النقر على أي رابط داخلها (لتحسين تجربة المستخدم)
document.querySelectorAll('.nav-links a').forEach(link => {
    link.addEventListener('click', () => {
        const navLinks = document.getElementById('navLinks');
        // إذا كانت القائمة نشطة (مفتوحة)، قم بإغلاقها
        if (navLinks.classList.contains('active')) {
            navLinks.classList.remove('active');
        }
    });
});

// وظيفة الرسوم المتحركة للعناصر عند التمرير إلى رؤيتها
document.addEventListener('DOMContentLoaded', () => {
    // خيارات Intersection Observer
    const observerOptions = {
        root: null, // عنصر root هو viewport (نافذة العرض)
        rootMargin: '0px', // لا يوجد هامش إضافي للـ viewport
        threshold: 0.1 // تفعيل العنصر عندما يكون 10% منه مرئيًا في الـ viewport
    };

    // إنشاء Intersection Observer
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            // إذا كان العنصر مرئيًا (isIntersecting)
            if (entry.isIntersecting) {
                entry.target.classList.add('animated'); // إضافة كلاس 'animated' لتفعيل الرسوم المتحركة
                observer.unobserve(entry.target); // إيقاف المراقبة بعد تفعيل الرسوم المتحركة مرة واحدة
            }
        });
    }, observerOptions);

    // مراقبة جميع العناصر التي تحمل كلاس 'animate-on-scroll'
    document.querySelectorAll('.animate-on-scroll').forEach(element => {
        observer.observe(element);
    });
});
