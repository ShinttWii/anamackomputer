/* ============================================================
   MAIN JS — Sistem Pakar aMK
   Micro-interactions, animasi, dan interaksi komponen
   ============================================================ */
document.addEventListener('DOMContentLoaded', function () {

  /* ── 1. SIDEBAR TOGGLE ── */
  const sidebarToggle = document.getElementById('sidebarToggle');
  const adminSidebar  = document.getElementById('adminSidebar');
  const adminMain     = document.getElementById('adminMain');

  if (sidebarToggle && adminSidebar) {
    sidebarToggle.addEventListener('click', function () {
      adminSidebar.classList.toggle('open');
    });

    // Tutup sidebar saat klik di luar (mobile)
    document.addEventListener('click', function (e) {
      if (window.innerWidth < 992
          && adminSidebar.classList.contains('open')
          && !adminSidebar.contains(e.target)
          && !sidebarToggle.contains(e.target)) {
        adminSidebar.classList.remove('open');
      }
    });
  }

  /* ── 2. NAVBAR SCROLL EFFECT ── */
  const navbar = document.querySelector('.navbar-amk');
  if (navbar) {
    const updateNavbar = () => {
      navbar.classList.toggle('scrolled', window.scrollY > 10);
    };
    window.addEventListener('scroll', updateNavbar, { passive: true });
    updateNavbar();
  }

  /* ── 3. GEJALA CHECKBOX COUNTER ── */
  const checkboxes = document.querySelectorAll('.gejala-checkbox');
  const counter    = document.getElementById('gejalaCounter');
  const submitBtn  = document.getElementById('btnDiagnosa');

  function updateCounter() {
    const checked = document.querySelectorAll('.gejala-checkbox:checked').length;
    if (counter) {
      counter.textContent = checked;
      // Animasi counter
      counter.style.transform = 'scale(1.3)';
      setTimeout(() => counter.style.transform = 'scale(1)', 150);
    }
    if (submitBtn) {
      submitBtn.disabled = checked === 0;
      submitBtn.style.opacity = checked === 0 ? '0.55' : '1';
    }
    document.querySelectorAll('.gejala-item').forEach(item => {
      const cb = item.querySelector('input[type=checkbox]');
      item.classList.toggle('selected', cb && cb.checked);
    });
  }

  if (checkboxes.length) {
    checkboxes.forEach(cb => cb.addEventListener('change', updateCounter));
    updateCounter();

    // Klik seluruh row gejala
    document.querySelectorAll('.gejala-item').forEach(item => {
      item.addEventListener('click', function (e) {
        if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'LABEL') {
          const cb = item.querySelector('input[type=checkbox]');
          if (cb) { cb.checked = !cb.checked; updateCounter(); }
        }
      });
    });
  }

  /* ── 4. FORM KONSULTASI VALIDATION ── */
  const formKonsultasi = document.getElementById('formKonsultasi');
  if (formKonsultasi) {
    formKonsultasi.addEventListener('submit', function (e) {
      const checked = document.querySelectorAll('.gejala-checkbox:checked').length;
      if (checked === 0) {
        e.preventDefault();
        // Tampilkan notifikasi inline daripada alert
        let existingAlert = document.getElementById('gejalaAlert');
        if (!existingAlert) {
          existingAlert = document.createElement('div');
          existingAlert.id = 'gejalaAlert';
          existingAlert.className = 'alert alert-warning alert-dismissible fade show mt-3';
          existingAlert.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Pilih minimal satu gejala sebelum melanjutkan.<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
          formKonsultasi.prepend(existingAlert);
        }
        existingAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
      } else {
        // Loading state
        const btn = document.getElementById('btnDiagnosa');
        if (btn) {
          btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses...';
          btn.disabled = true;
        }
      }
    });
  }

  /* ── 5. CONFIRM DELETE ── */
  document.querySelectorAll('.btn-confirm-delete').forEach(btn => {
    btn.addEventListener('click', function (e) {
      if (!confirm('Yakin ingin menghapus data ini? Tindakan tidak dapat dibatalkan.')) {
        e.preventDefault();
      }
    });
  });

  /* ── 6. AUTO DISMISS ALERTS ── */
  document.querySelectorAll('.alert-auto-dismiss').forEach(alertEl => {
    setTimeout(() => {
      if (typeof bootstrap !== 'undefined') {
        const bsAlert = bootstrap.Alert.getOrCreateInstance(alertEl);
        if (bsAlert) bsAlert.close();
      } else {
        alertEl.style.transition = 'opacity .4s ease';
        alertEl.style.opacity = '0';
        setTimeout(() => alertEl.remove(), 400);
      }
    }, 4500);
  });

  /* ── 7. CETAK HASIL ── */
  const btnCetak = document.getElementById('btnCetak');
  if (btnCetak) {
    btnCetak.addEventListener('click', () => window.print());
  }

  /* ── 8. ANIMATE CARDS ON SCROLL ── */
  if ('IntersectionObserver' in window) {
    const observerOpts = { threshold: 0.1, rootMargin: '0px 0px -30px 0px' };
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('anim-visible');
          observer.unobserve(entry.target);
        }
      });
    }, observerOpts);

    document.querySelectorAll('.anim-on-scroll').forEach(el => observer.observe(el));
  } else {
    // Fallback: show all immediately
    document.querySelectorAll('.anim-on-scroll').forEach(el => el.classList.add('anim-visible'));
  }

  /* ── 9. COUNTER ANIMATION (dashboard stats) ── */
  function animateCounter(el) {
    const target = parseInt(el.dataset.target || el.textContent.replace(/\D/g,''), 10);
    if (isNaN(target) || target === 0) return;
    const duration = 800;
    const step = Math.ceil(target / (duration / 16));
    let current = 0;
    const timer = setInterval(() => {
      current = Math.min(current + step, target);
      el.textContent = current.toLocaleString('id-ID');
      if (current >= target) clearInterval(timer);
    }, 16);
  }

  document.querySelectorAll('.s-num[data-target]').forEach(el => {
    const io = new IntersectionObserver(entries => {
      if (entries[0].isIntersecting) { animateCounter(el); io.disconnect(); }
    }, { threshold: 0.5 });
    io.observe(el);
  });

  /* ── 10. TOOLTIP INIT ── */
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
    new bootstrap.Tooltip(el, { trigger: 'hover' });
  });

  /* ── 11. TABLE ROW HOVER HIGHLIGHT ── */
  document.querySelectorAll('.amk-table tbody tr').forEach(tr => {
    tr.style.transition = 'background .15s ease';
  });

  /* ── 12. INPUT FOCUS RING ── */
  document.querySelectorAll('.form-control, .form-select').forEach(input => {
    input.addEventListener('focus', function () {
      this.closest('.input-group')?.classList.add('focused');
    });
    input.addEventListener('blur', function () {
      this.closest('.input-group')?.classList.remove('focused');
    });
  });

});

/* ── CSS for anim-on-scroll — inject hanya jika ada elemen yang perlu dianimasikan ── */
if (document.querySelector('.anim-on-scroll')) {
  var animStyle = document.createElement('style');
  animStyle.textContent =
    '.anim-on-scroll { opacity: 0; transform: translateY(20px); transition: opacity .45s ease, transform .45s ease; }' +
    '.anim-on-scroll.anim-visible { opacity: 1; transform: translateY(0); }' +
    '.counter-el { transition: transform .15s ease; }' +
    '.input-group.focused .input-group-text { border-color: #F28C28; }';
  document.head.appendChild(animStyle);
}
