// script.js

// ====== CONFIG (GANTI INI NANTI) ======
// Nomor WA admin dalam format E.164 Indonesia: 62 + nomor tanpa 0 depan.
// Contoh kalau nomor kamu 0812-9999-8888 => 6281299998888
const ADMIN_WA_E164 = "6281234567890"; // <-- GANTI KE NOMOR ASLI
const ADMIN_WA_DISPLAY = "0812-3456-7890"; // <-- GANTI TEKS NOMOR
const DEFAULT_WA_TEXT =
    "Assalamu’alaikum, saya ingin bertanya tentang Penerimaan Santri Baru (MA) di Pondok Pesantren DARUSSALAM AL-HAFIDZ, Kota Jambi.";

// Helper to build wa.me link
function buildWaLink(text = DEFAULT_WA_TEXT) {
    const msg = encodeURIComponent(text);
    return `https://wa.me/${ADMIN_WA_E164}?text=${msg}`;
}

// ====== INIT LINKS ======
function initWhatsAppLinks() {
    const links = [
        document.getElementById("waFloat"),
        document.getElementById("btnWaSticky"),
        document.getElementById("btnWaClosing"),
        document.getElementById("btnWaSide"),
        document.getElementById("footerWa"),
    ].filter(Boolean);

    links.forEach((a) => {
        a.href = buildWaLink();
        if (a.id === "footerWa") a.textContent = ADMIN_WA_DISPLAY;
    });
}

// ====== NAV TOGGLE (MOBILE) ======
function initNavToggle() {
    const btn = document.querySelector(".nav__toggle");
    const menu = document.getElementById("navMenu");
    if (!btn || !menu) return;

    btn.addEventListener("click", () => {
        const open = menu.classList.toggle("is-open");
        btn.setAttribute("aria-expanded", String(open));
    });

    menu.querySelectorAll("a.nav__link, .nav__actions a").forEach((a) => {
        a.addEventListener("click", () => {
            menu.classList.remove("is-open");
            btn.setAttribute("aria-expanded", "false");
        });
    });

    document.addEventListener("click", (e) => {
        if (window.matchMedia("(max-width: 760px)").matches) {
            const isInside = menu.contains(e.target) || btn.contains(e.target);
            if (!isInside) {
                menu.classList.remove("is-open");
                btn.setAttribute("aria-expanded", "false");
            }
        }
    });
}

// ====== TABS ======
function initTabs() {
    const root = document.querySelector("[data-tabs]");
    if (!root) return;
    const tabs = Array.from(root.querySelectorAll(".tabs__tab"));
    const panels = Array.from(root.querySelectorAll(".tabs__panel"));

    function activate(tab) {
        tabs.forEach((t) => {
            const isActive = t === tab;
            t.classList.toggle("is-active", isActive);
            t.setAttribute("aria-selected", String(isActive));
            t.tabIndex = isActive ? 0 : -1;
        });

        const id = tab.getAttribute("aria-controls");
        panels.forEach((p) => p.classList.toggle("is-active", p.id === id));
    }

    tabs.forEach((t) => {
        t.addEventListener("click", () => activate(t));
        t.addEventListener("keydown", (e) => {
            const idx = tabs.indexOf(t);
            if (e.key === "ArrowRight") activate(tabs[(idx + 1) % tabs.length]);
            if (e.key === "ArrowLeft")
                activate(tabs[(idx - 1 + tabs.length) % tabs.length]);
        });
    });
}

// ====== ACCORDION ======
function initAccordion() {
    const root = document.querySelector("[data-accordion]");
    if (!root) return;

    root.querySelectorAll(".accItem").forEach((item) => {
        const btn = item.querySelector(".accBtn");
        const panel = item.querySelector(".accPanel");
        const icon = item.querySelector(".accIcon");
        if (!btn || !panel) return;

        btn.addEventListener("click", () => {
            const expanded = btn.getAttribute("aria-expanded") === "true";
            btn.setAttribute("aria-expanded", String(!expanded));
            panel.hidden = expanded;
            if (icon) icon.textContent = expanded ? "+" : "–";
        });
    });
}

// ====== FORM (DEMO) ======
function initForm() {
    const form = document.getElementById("psbForm");
    const msg = document.getElementById("formMsg");
    const btnPrefill = document.getElementById("btnPrefill");
    if (!form || !msg) return;

    function showMessage(text, type = "info") {
        msg.textContent = text;
        msg.style.padding = "10px 12px";
        msg.style.borderRadius = "14px";
        msg.style.border = "1px solid rgba(231,226,216,0.95)";
        msg.style.background =
            type === "ok"
                ? "rgba(15,118,110,0.10)"
                : type === "warn"
                ? "rgba(200,162,77,0.14)"
                : "rgba(255,255,255,0.70)";
    }

    btnPrefill?.addEventListener("click", () => {
        form.nama.value = "Ahmad Fulan";
        form.jenjang.value = "MA";
        form.email.value = "ahmad@example.com";
        form.password.value = "password123";
        form.wa.value = "081234567890";
        showMessage(
            "Contoh data sudah diisi. Silakan ubah sesuai data Anda.",
            "info"
        );
    });

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const required = ["nama", "jenjang", "email", "password", "wa"];
        const missing = required.filter(
            (name) => !String(form[name].value || "").trim()
        );

        if (missing.length) {
            showMessage("Mohon lengkapi semua field yang wajib diisi.", "warn");
            form[missing[0]]?.focus?.();
            return;
        }

        showMessage("Mengirim data...", "info");

        try {
            const formData = new FormData(form);
            const token = document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute("content");

            if (!token) {
                showMessage(
                    "Token keamanan tidak ditemukan. Silakan refresh halaman.",
                    "warn"
                );
                return;
            }

            const response = await fetch("/register", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": token,
                    Accept: "application/json",
                },
                body: formData,
            });

            const data = await response.json();

            if (response.ok) {
                showMessage(data.message, "ok");
                form.reset();

                // SweetAlert Success & Redirect to Login
                Swal.fire({
                    title: "Pendaftaran Berhasil!",
                    text: "Silakan login menggunakan email dan password yang telah didaftarkan untuk melengkapi berkas.",
                    icon: "success",
                    confirmButtonText: "Login Sekarang",
                    confirmButtonColor: "#0f766e",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Scroll to login section or redirect to login page if separate
                        // For now, assuming login form is on the same page (in footer/modal) or just focus
                        // But user request implies redirect to login/dashboard flow.
                        // Since login form is on the same page (L714-729), we can scroll to it.
                        // Or better, reload page or trigger login modal if exists.
                        // Based on user request: "arahkan santri untuk login"

                        // Let's scroll to the login form area
                        const loginSection = document.getElementById("login"); // Assuming section ID or similar
                        if (loginSection) {
                            loginSection.scrollIntoView({ behavior: "smooth" });
                        } else {
                            // Fallback: scroll to bottom where footer login usually is
                            window.scrollTo({
                                top: document.body.scrollHeight,
                                behavior: "smooth",
                            });
                        }
                    }
                });
            } else {
                let errorMessage = data.message || "Terjadi kesalahan.";
                if (data.errors) {
                    errorMessage +=
                        " " + Object.values(data.errors).flat().join(" ");
                }
                showMessage(errorMessage, "warn");
            }
        } catch (error) {
            console.error(error);
            showMessage(
                "Terjadi kesalahan jaringan. Silakan coba lagi.",
                "warn"
            );
        }
    });
}

// ====== STATUS CHECK (DEMO) ======
function initStatusCheck() {
    const input = document.getElementById("statusInput");
    const btn = document.getElementById("btnCekStatus");
    const out = document.getElementById("statusResult");
    if (!input || !btn || !out) return;

    function render(text, type = "info") {
        out.textContent = text;
        out.style.padding = "10px 12px";
        out.style.borderRadius = "14px";
        out.style.border = "1px solid rgba(231,226,216,0.95)";
        out.style.background =
            type === "ok"
                ? "rgba(15,118,110,0.10)"
                : type === "warn"
                ? "rgba(200,162,77,0.14)"
                : "rgba(255,255,255,0.70)";
    }

    btn.addEventListener("click", () => {
        const val = String(input.value || "").trim();
        if (!val)
            return render("Masukkan nomor WhatsApp terlebih dahulu.", "warn");

        const last = val.replace(/\D/g, "").slice(-1);
        const states = [
            "Status: Baru masuk — menunggu verifikasi berkas.",
            "Status: Berkas kurang — admin akan menghubungi.",
            "Status: Terverifikasi — menunggu jadwal tes.",
            "Status: Tes selesai — menunggu pengumuman.",
            "Status: Lulus — silakan daftar ulang.",
        ];
        const idx = Number(last || 0) % states.length;
        render(states[idx], "ok");
    });
}

// ====== MODAL ======
function initModal() {
    const modals = document.querySelectorAll(".modal");
    if (!modals.length) return;

    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add("is-open");
            modal.setAttribute("aria-hidden", "false");
            document.body.style.overflow = "hidden";
            const input = modal.querySelector("input, button");
            if (input) input.focus();
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove("is-open");
            modal.setAttribute("aria-hidden", "true");
            document.body.style.overflow = "";
        }
    }

    document.querySelectorAll("[data-modal]").forEach((trigger) => {
        trigger.addEventListener("click", (e) => {
            e.preventDefault();
            const id = trigger.getAttribute("data-modal");
            openModal(id);
        });
    });

    document.querySelectorAll("[data-close]").forEach((closer) => {
        closer.addEventListener("click", (e) => {
            const id = closer.getAttribute("data-close");
            closeModal(id);
        });
    });

    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            const openModal = document.querySelector(".modal.is-open");
            if (openModal) {
                closeModal(openModal.id);
            }
        }
    });
}

// ====== YEAR ======
function initYear() {
    const el = document.getElementById("year");
    if (el) el.textContent = String(new Date().getFullYear());
}

// ====== BOOT ======
document.addEventListener("DOMContentLoaded", () => {
    initWhatsAppLinks();
    initNavToggle();
    initTabs();
    initAccordion();
    initForm();
    initStatusCheck();
    initModal();
    initYear();
});
