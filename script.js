// script.js
// هذا الكود يتضمن وظائف شريط التنقل المتجاوب، التصغير عند التمرير، والرسوم المتحركة عند التمرير.
// وظيفة إرسال النموذج هنا هي للمظهر فقط ولا تقوم بإرسال بيانات حقيقية.

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

// معالج إرسال النموذج (للمظهر فقط - لا يوجد إرسال بيانات حقيقي)
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('.contact-form');
    const formMessages = document.getElementById('form-messages');

    if (contactForm && formMessages) { // التأكد من وجود النموذج وعنصر الرسائل
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault(); // منع الإرسال الافتراضي للنموذج (الذي يؤدي إلى إعادة تحميل الصفحة)

            // تحقق من أن الحقول المطلوبة ليست فارغة (تحقق بسيط من جانب العميل)
            const name = contactForm.querySelector('input[name="name"]').value.trim();
            const email = contactForm.querySelector('input[name="email"]').value.trim();
            const subject = contactForm.querySelector('input[name="subject"]').value.trim();
            const message = contactForm.querySelector('textarea[name="message"]').value.trim();

            if (!name || !email || !subject || !message) {
                formMessages.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Please fill in all required fields.';
                formMessages.style.color = '#f44336'; // لون أحمر للخطأ
                return; // إيقاف التنفيذ إذا كانت الحقول فارغة
            }

            // عرض رسالة "جاري الإرسال..." (للمظهر فقط)
            formMessages.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending your message...';
            formMessages.style.color = '#ffd700'; // لون أصفر/ذهبي لرسالة التحميل

            // محاكاة عملية الإرسال (تأخير زمني قصير)
            setTimeout(() => {
                // عرض رسالة النجاح
                formMessages.innerHTML = '<i class="fas fa-check-circle"></i> Your message has been received successfully!';
                formMessages.style.color = '#4CAF50'; // لون أخضر للنجاح
                contactForm.reset(); // مسح حقول النموذج بعد "الإرسال"
            }, 1500); // تأخير 1.5 ثانية لمحاكاة الإرسال
        });
    }
});
