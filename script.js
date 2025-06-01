// هذا هو الكود الكامل لملف script.js

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

// معالج إرسال النموذج (باستخدام Fetch API لإرسال AJAX)
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('.contact-form');
    const formMessages = document.getElementById('form-messages');

    // التأكد من وجود النموذج في الصفحة
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault(); // منع الإرسال الافتراضي للنموذج (الذي يؤدي إلى إعادة تحميل الصفحة)

            // عرض رسالة "جاري الإرسال..." مع أيقونة التحميل
            formMessages.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            formMessages.style.color = '#ffd700'; // لون أصفر/ذهبي لرسالة التحميل

            // جمع بيانات النموذج
            const formData = new FormData(this); // يقوم بجمع جميع بيانات حقول النموذج

            // إرسال البيانات باستخدام Fetch API
            fetch('send_email.php', {
                method: 'POST', // تحديد طريقة الإرسال كـ POST
                body: formData // إرسال البيانات
            })
            .then(response => {
                // التحقق من حالة استجابة HTTP (مثلاً 200 OK، 404 Not Found، 500 Internal Server Error)
                if (!response.ok) {
                    // إذا كان هناك خطأ في استجابة HTTP، ارمِ خطأ ليتم التقاطه في .catch
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json(); // تحليل استجابة الخادم كـ JSON
            })
            .then(data => {
                // معالجة بيانات JSON المستلمة من الخادم
                if (data.status === 'success') {
                    // إذا كانت حالة النجاح من الخادم
                    formMessages.innerHTML = '<i class="fas fa-check-circle"></i> ' + data.message; // عرض رسالة النجاح
                    formMessages.style.color = '#4CAF50'; // لون أخضر
                    contactForm.reset(); // مسح حقول النموذج بعد الإرسال الناجح
                } else {
                    // إذا كانت حالة الخطأ من الخادم
                    formMessages.innerHTML = '<i class="fas fa-exclamation-triangle"></i> ' + data.message; // عرض رسالة الخطأ
                    formMessages.style.color = '#f44336'; // لون أحمر
                }
            })
            .catch(error => {
                // معالجة الأخطاء التي تحدث أثناء عملية fetch (مثل فشل الاتصال، أخطاء الشبكة، أو أخطاء HTTP)
                console.error('Fetch Error:', error); // طباعة الخطأ في console المتصفح للمطور
                formMessages.innerHTML = '<i class="fas fa-exclamation-triangle"></i> An error occurred during submission. Please try again.'; // رسالة خطأ عامة للمستخدم
                formMessages.style.color = '#f44336';
            });
        });
    }
});
