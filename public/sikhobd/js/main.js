/* ============================================
   10 Minute School — JS
   - Mobile drawer with N-level nesting
   - Language toggle (BN / EN) with localStorage
   ============================================ */

/* ---------- Mobile drawer ---------- */
const drawer = document.getElementById('drawer');
const overlay = document.getElementById('drawerOverlay');
const openBtn = document.getElementById('menuToggle');
const closeBtn = document.getElementById('drawerClose');

function openDrawer() {
  drawer?.classList.add('open');
  overlay?.classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeDrawer() {
  drawer?.classList.remove('open');
  overlay?.classList.remove('open');
  document.body.style.overflow = '';
}
openBtn?.addEventListener('click', openDrawer);
closeBtn?.addEventListener('click', closeDrawer);
overlay?.addEventListener('click', closeDrawer);

/* Mobile collapsible items — works for unlimited depth */
document.querySelectorAll('.m-toggle').forEach((btn) => {
  btn.addEventListener('click', (e) => {
    e.stopPropagation();
    btn.parentElement.classList.toggle('open');
  });
});

/* ---------- Language toggle (BN / EN) ----------
   Any element with data-i18n="key" gets translated.
   Any element with data-i18n-attr="placeholder|key" sets attribute.
*/
const i18n = {
  bn: {
    'nav.courses': 'কোর্সসমূহ',
    'nav.academic': 'একাডেমিক',
    'nav.skills': 'স্কিলস',
    'nav.language': 'ভাষা শিক্ষা',
    'nav.study': 'পড়ালেখা',
    'nav.career': 'দক্ষতা',
    'nav.about': 'আমাদের সম্পর্কে',
    'nav.contact': 'যোগাযোগ',
    'nav.blog': 'ব্লগ',
    'nav.pricing': 'প্রাইসিং',
    'nav.dashboard': 'ড্যাশবোর্ড',
    'nav.login': 'লগইন',
    'nav.signup': 'সাইন আপ',
    'nav.download': 'ডাউনলোড অ্যাপ',
    'nav.class6': 'ক্লাস ৬-৮',
    'nav.class9': 'ক্লাস ৯-১০ (SSC)',
    'nav.class11': 'ক্লাস ১১-১২ (HSC)',
    'nav.admission': 'ভর্তি প্রস্তুতি',
    'nav.medical': 'মেডিকেল',
    'nav.varsity': 'ভার্সিটি',
    'nav.engineering': 'ইঞ্জিনিয়ারিং',
    'nav.buet': 'BUET',
    'nav.ku': 'KUET',
    'nav.cu': 'CUET',
    'nav.freelancing': 'ফ্রিল্যান্সিং',
    'nav.design': 'ডিজাইন',
    'nav.development': 'ডেভেলপমেন্ট',
    'nav.web': 'ওয়েব ডেভেলপমেন্ট',
    'nav.mobile': 'মোবাইল অ্যাপ',
    'nav.frontend': 'ফ্রন্টএন্ড',
    'nav.backend': 'ব্যাকএন্ড',
    'nav.fullstack': 'ফুল স্ট্যাক',
    'nav.spoken': 'Spoken English',
    'nav.ielts': 'IELTS',
    'nav.arabic': 'Arabic',
    'nav.notes': 'ফ্রি নোটস',
    'nav.test': 'মডেল টেস্ট',
    'nav.live': 'লাইভ ক্লাস',
    'nav.bcs': 'BCS প্রিলি',
    'nav.bank': 'ব্যাংক জব',
    'nav.job': 'জব প্রস্তুতি',

    'hero.eyebrow': 'বাংলাদেশের #১ অনলাইন স্কুল',
    'hero.title1': 'শিখুন',
    'hero.title2': 'যেকোনো কিছু',
    'hero.title3': 'যেকোনো সময়, যেকোনো জায়গায়',
    'hero.desc': 'ক্লাস ৬ থেকে ১২, ভর্তি প্রস্তুতি, স্কিল ডেভেলপমেন্ট সহ ১০০০+ কোর্স একসাথে।',
    'hero.explore': 'এক্সপ্লোর কোর্স',
    'hero.freeclass': 'ফ্রি ক্লাস দেখুন',
    'hero.students': 'শিক্ষার্থী',
    'hero.courses': 'কোর্স',
    'hero.teachers': 'শিক্ষক',

    'sec.cat': 'ক্যাটাগরি অনুযায়ী',
    'sec.cat2': 'কোর্স',
    'sec.cat.sub': 'আপনার আগ্রহ অনুযায়ী যেকোনো ক্যাটাগরি বেছে নিন',
    'sec.popular': 'জনপ্রিয়',
    'sec.popular2': 'কোর্সসমূহ',
    'sec.popular.sub': 'হাজারো শিক্ষার্থীর পছন্দের কোর্স',
    'sec.why': 'কেন',
    'sec.why2': '10 Minute School?',
    'cta.title': 'আজই অ্যাপ ডাউনলোড করুন',
    'cta.desc': '২ মিলিয়নের বেশি শিক্ষার্থীর সাথে যোগ দিন।',
    'cta.btn': 'এখনই ডাউনলোড',

    'footer.about': 'বাংলাদেশের সবচেয়ে বড় অনলাইন শিক্ষাপ্ল্যাটফর্ম। যেকোনো সময়, যেকোনো জায়গা থেকে শেখার সুযোগ।',
    'footer.company': 'কোম্পানি',
    'footer.career': 'ক্যারিয়ার',
    'footer.partner': 'পার্টনার',
    'footer.support': 'সাপোর্ট',
    'footer.help': 'হেল্প সেন্টার',
    'footer.privacy': 'গোপনীয়তা',
    'footer.terms': 'শর্তাবলী',
    'footer.copy': '© 2025 10 Minute School. সর্বস্বত্ব সংরক্ষিত।',

    'page.about.title': 'আমাদের সম্পর্কে',
    'page.about.sub': 'শিক্ষা সবার জন্য — এই বিশ্বাস থেকেই আমাদের যাত্রা শুরু',
    'page.contact.title': 'যোগাযোগ করুন',
    'page.contact.sub': 'যেকোনো প্রশ্ন বা পরামর্শে আমরা সবসময় প্রস্তুত',
    'page.courses.title': 'সকল কোর্স',
    'page.courses.sub': '১০০০+ কোর্স — আপনার পছন্দ অনুযায়ী বেছে নিন',
    'page.blog.title': 'ব্লগ ও আর্টিকেল',
    'page.blog.sub': 'শিক্ষা, ক্যারিয়ার ও দক্ষতা বিষয়ক সর্বশেষ লেখা',
    'page.pricing.title': 'প্রাইসিং প্ল্যান',
    'page.pricing.sub': 'আপনার জন্য সঠিক প্ল্যান বেছে নিন',
    'page.dashboard.title': 'ড্যাশবোর্ড',
    'page.dashboard.sub': 'স্বাগতম! আপনার শেখার অগ্রগতি দেখুন',
    'page.login.title': 'লগইন করুন',
    'page.login.sub': 'আপনার অ্যাকাউন্টে প্রবেশ করুন',
    'page.signup.title': 'অ্যাকাউন্ট তৈরি করুন',
    'page.signup.sub': 'বিনামূল্যে শুরু করুন',

    'enroll': 'এনরোল',
    'filter': 'ফিল্টার',
    'category': 'ক্যাটাগরি',
    'level': 'লেভেল',
    'price.range': 'মূল্য',
    'all': 'সব',
    'beginner': 'বিগিনার',
    'intermediate': 'ইন্টারমিডিয়েট',
    'advanced': 'অ্যাডভান্স',

    'form.name': 'আপনার নাম',
    'form.email': 'ইমেইল',
    'form.phone': 'ফোন',
    'form.subject': 'বিষয়',
    'form.message': 'আপনার বার্তা',
    'form.send': 'বার্তা পাঠান',
    'form.password': 'পাসওয়ার্ড',
    'form.cpassword': 'পাসওয়ার্ড নিশ্চিত করুন',
    'form.remember': 'আমাকে মনে রাখুন',
    'form.forgot': 'পাসওয়ার্ড ভুলে গেছেন?',
    'form.have': 'অ্যাকাউন্ট আছে?',
    'form.dont': 'অ্যাকাউন্ট নেই?',
    'form.or': 'অথবা',

    'dash.menu.overview': 'ওভারভিউ',
    'dash.menu.courses': 'আমার কোর্স',
    'dash.menu.live': 'লাইভ ক্লাস',
    'dash.menu.cert': 'সার্টিফিকেট',
    'dash.menu.notes': 'নোটস',
    'dash.menu.payment': 'পেমেন্ট',
    'dash.menu.profile': 'প্রোফাইল',
    'dash.menu.settings': 'সেটিংস',
    'dash.menu.logout': 'লগআউট',
    'dash.stat.enrolled': 'এনরোলড কোর্স',
    'dash.stat.completed': 'সম্পন্ন',
    'dash.stat.hours': 'শিখার সময়',
    'dash.stat.cert': 'সার্টিফিকেট',
    'dash.continue': 'শেখা চালিয়ে যান',
    'dash.activity': 'সাম্প্রতিক কার্যক্রম',
    'dash.viewall': 'সব দেখুন',
  },
  en: {
    'nav.courses': 'Courses',
    'nav.academic': 'Academic',
    'nav.skills': 'Skills',
    'nav.language': 'Language',
    'nav.study': 'Study',
    'nav.career': 'Career',
    'nav.about': 'About Us',
    'nav.contact': 'Contact',
    'nav.blog': 'Blog',
    'nav.pricing': 'Pricing',
    'nav.dashboard': 'Dashboard',
    'nav.login': 'Login',
    'nav.signup': 'Sign Up',
    'nav.download': 'Download App',
    'nav.class6': 'Class 6-8',
    'nav.class9': 'Class 9-10 (SSC)',
    'nav.class11': 'Class 11-12 (HSC)',
    'nav.admission': 'Admission Prep',
    'nav.medical': 'Medical',
    'nav.varsity': 'University',
    'nav.engineering': 'Engineering',
    'nav.buet': 'BUET',
    'nav.ku': 'KUET',
    'nav.cu': 'CUET',
    'nav.freelancing': 'Freelancing',
    'nav.design': 'Design',
    'nav.development': 'Development',
    'nav.web': 'Web Development',
    'nav.mobile': 'Mobile App',
    'nav.frontend': 'Frontend',
    'nav.backend': 'Backend',
    'nav.fullstack': 'Full Stack',
    'nav.spoken': 'Spoken English',
    'nav.ielts': 'IELTS',
    'nav.arabic': 'Arabic',
    'nav.notes': 'Free Notes',
    'nav.test': 'Model Test',
    'nav.live': 'Live Class',
    'nav.bcs': 'BCS Preli',
    'nav.bank': 'Bank Job',
    'nav.job': 'Job Prep',

    'hero.eyebrow': "Bangladesh's #1 Online School",
    'hero.title1': 'Learn',
    'hero.title2': 'anything',
    'hero.title3': 'anytime, anywhere',
    'hero.desc': '1000+ courses for Class 6-12, admission prep & skill development — all in one place.',
    'hero.explore': 'Explore Courses',
    'hero.freeclass': 'Watch Free Class',
    'hero.students': 'Students',
    'hero.courses': 'Courses',
    'hero.teachers': 'Teachers',

    'sec.cat': 'Browse by',
    'sec.cat2': 'category',
    'sec.cat.sub': 'Pick a category that matches your interest',
    'sec.popular': 'Popular',
    'sec.popular2': 'courses',
    'sec.popular.sub': 'Loved by thousands of students',
    'sec.why': 'Why',
    'sec.why2': '10 Minute School?',
    'cta.title': 'Download the app today',
    'cta.desc': 'Join over 2 million students.',
    'cta.btn': 'Download Now',

    'footer.about': "Bangladesh's largest online learning platform. Learn anytime, anywhere.",
    'footer.company': 'Company',
    'footer.career': 'Careers',
    'footer.partner': 'Partners',
    'footer.support': 'Support',
    'footer.help': 'Help Center',
    'footer.privacy': 'Privacy',
    'footer.terms': 'Terms',
    'footer.copy': '© 2025 10 Minute School. All rights reserved.',

    'page.about.title': 'About Us',
    'page.about.sub': 'Education for everyone — that belief started our journey',
    'page.contact.title': 'Get in Touch',
    'page.contact.sub': "We're here for any question or feedback",
    'page.courses.title': 'All Courses',
    'page.courses.sub': '1000+ courses — pick what fits you',
    'page.blog.title': 'Blog & Articles',
    'page.blog.sub': 'Latest on learning, careers and skills',
    'page.pricing.title': 'Pricing Plans',
    'page.pricing.sub': 'Choose the right plan for you',
    'page.dashboard.title': 'Dashboard',
    'page.dashboard.sub': 'Welcome back! Track your learning progress',
    'page.login.title': 'Sign In',
    'page.login.sub': 'Access your account',
    'page.signup.title': 'Create Account',
    'page.signup.sub': 'Get started for free',

    'enroll': 'Enroll',
    'filter': 'Filter',
    'category': 'Category',
    'level': 'Level',
    'price.range': 'Price',
    'all': 'All',
    'beginner': 'Beginner',
    'intermediate': 'Intermediate',
    'advanced': 'Advanced',

    'form.name': 'Your name',
    'form.email': 'Email',
    'form.phone': 'Phone',
    'form.subject': 'Subject',
    'form.message': 'Your message',
    'form.send': 'Send Message',
    'form.password': 'Password',
    'form.cpassword': 'Confirm password',
    'form.remember': 'Remember me',
    'form.forgot': 'Forgot password?',
    'form.have': 'Have an account?',
    'form.dont': "Don't have an account?",
    'form.or': 'or',

    'dash.menu.overview': 'Overview',
    'dash.menu.courses': 'My Courses',
    'dash.menu.live': 'Live Classes',
    'dash.menu.cert': 'Certificates',
    'dash.menu.notes': 'Notes',
    'dash.menu.payment': 'Payments',
    'dash.menu.profile': 'Profile',
    'dash.menu.settings': 'Settings',
    'dash.menu.logout': 'Logout',
    'dash.stat.enrolled': 'Enrolled Courses',
    'dash.stat.completed': 'Completed',
    'dash.stat.hours': 'Learning Hours',
    'dash.stat.cert': 'Certificates',
    'dash.continue': 'Continue learning',
    'dash.activity': 'Recent activity',
    'dash.viewall': 'View all',
  },
};

function applyLang(lang) {
  const dict = i18n[lang] || i18n.bn;
  document.documentElement.lang = lang;
  document.querySelectorAll('[data-i18n]').forEach((el) => {
    const key = el.getAttribute('data-i18n');
    if (dict[key] != null) el.textContent = dict[key];
  });
  document.querySelectorAll('[data-i18n-attr]').forEach((el) => {
    const [attr, key] = el.getAttribute('data-i18n-attr').split('|');
    if (attr && key && dict[key] != null) el.setAttribute(attr, dict[key]);
  });
  document.querySelectorAll('.lang-switch button').forEach((b) => {
    b.classList.toggle('active', b.dataset.lang === lang);
  });
  try { localStorage.setItem('lang', lang); } catch (_) {}
}

document.addEventListener('click', (e) => {
  const btn = e.target.closest('.lang-switch button');
  if (btn) applyLang(btn.dataset.lang);
});

const savedLang = (() => { try { return localStorage.getItem('lang'); } catch (_) { return null; } })();
applyLang(savedLang || document.documentElement.lang || 'bn');

/* ---------- Course detail tabs ---------- */
document.querySelectorAll('.cd-tabs button').forEach((b) => {
  b.addEventListener('click', () => {
    document.querySelectorAll('.cd-tabs button').forEach((x) => x.classList.remove('active'));
    b.classList.add('active');
    const tab = b.dataset.tab;
    document.querySelectorAll('[data-tab-content]').forEach((p) => {
      p.style.display = p.dataset.tabContent === tab ? 'block' : 'none';
    });
  });
});
