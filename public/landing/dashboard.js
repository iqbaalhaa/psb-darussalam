document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("form.dashForm");
    if (!form) return;

    // progress elements
    const pct1 = document.getElementById("dashPct");
    const pct2 = document.getElementById("dashPct2");
    const fill = document.getElementById("dashFill");
    const hint = document.getElementById("dashProgressHint");
    const btnSticky = document.getElementById("btnStickySubmit");

    // required fields (text/select/textarea)
    const requiredFields = Array.from(
        form.querySelectorAll("[data-required='1']")
    );

    // required files
    const requiredFiles = Array.from(
        form.querySelectorAll("[data-required-file='1']")
    );

    // error helpers
    function setError(id, message) {
        const err = form.querySelector(`[data-error-for="${id}"]`);
        const input =
            form.querySelector(`#${CSS.escape(id)}`) ||
            form.querySelector(`[name="${id}"]`);
        if (err) {
            err.textContent = message || "";
            err.classList.toggle("is-show", Boolean(message));
        }
        if (input) input.classList.toggle("is-invalid", Boolean(message));
        const field = input?.closest?.(".field");
        if (field) field.classList.toggle("is-invalid", Boolean(message));
    }

    function clearError(id) {
        setError(id, "");
    }

    // normalize digits only
    function onlyDigits(str) {
        return String(str || "").replace(/\D/g, "");
    }

    // rules
    function validateField(el) {
        const id = el.id || el.name;
        const val = String(el.value || "").trim();
        const rule = el.getAttribute("data-rule");

        // required empty
        if (el.getAttribute("data-required") === "1") {
            if (!val) {
                setError(id, "Wajib diisi.");
                return false;
            }
        }

        if (rule === "nisn") {
            const d = onlyDigits(val);
            if (d.length !== 10) {
                setError(id, "NISN harus 10 digit angka.");
                return false;
            }
            clearError(id);
            return true;
        }

        if (rule === "nik") {
            const d = onlyDigits(val);
            if (d.length !== 16) {
                setError(id, "NIK harus 16 digit angka.");
                return false;
            }
            clearError(id);
            return true;
        }

        if (rule === "wa") {
            // accept: 08..., 62..., +62...
            const raw = String(val || "").trim();
            const ok =
                /^0?8[1-9][0-9]{7,11}$/.test(raw.replace(/\s+/g, "")) ||
                /^62?8[1-9][0-9]{7,11}$/.test(raw.replace(/\+|\s+/g, "")) ||
                /^\+628[1-9][0-9]{7,11}$/.test(raw.replace(/\s+/g, ""));
            if (!ok) {
                setError(id, "Format WA tidak valid. Contoh: 08xxxxxxxxxx");
                return false;
            }
            clearError(id);
            return true;
        }

        if (rule === "dob") {
            if (!val) {
                setError(id, "Wajib diisi.");
                return false;
            }
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const dt = new Date(val + "T00:00:00");
            if (isNaN(dt.getTime())) {
                setError(id, "Tanggal tidak valid.");
                return false;
            }
            if (dt > today) {
                setError(id, "Tanggal lahir tidak boleh di masa depan.");
                return false;
            }
            clearError(id);
            return true;
        }

        // default ok
        clearError(id);
        return true;
    }

    function validateFile(input) {
        const id = input.id;
        const maxMb = Number(input.getAttribute("data-max-mb") || "2");
        const existing = input.getAttribute("data-existing") === "1";
        const required = input.getAttribute("data-required-file") === "1";
        const file = input.files && input.files[0];

        // if required: must have file OR existing
        if (required && !existing && !file) {
            setError(id, "File wajib diupload.");
            return false;
        }

        // if no file selected, and existing ok
        if (!file) {
            clearError(id);
            return true;
        }

        // size check
        const sizeMb = file.size / (1024 * 1024);
        if (sizeMb > maxMb) {
            setError(id, `Ukuran file terlalu besar. Maks ${maxMb}MB.`);
            return false;
        }

        // accept check (basic)
        const accept = (input.getAttribute("accept") || "").toLowerCase();
        if (accept) {
            const name = file.name.toLowerCase();
            const ok = accept.includes("image/*")
                ? /^image\//.test(file.type)
                : accept.split(",").some((ext) => name.endsWith(ext.trim()));
            if (!ok) {
                setError(id, "Tipe file tidak sesuai.");
                return false;
            }
        }

        clearError(id);
        return true;
    }

    // progress calc
    function calcProgress() {
        let total = 0;
        let done = 0;

        // fields
        requiredFields.forEach((el) => {
            total++;
            const ok = validateField(el);
            if (ok && String(el.value || "").trim()) done++;
        });

        // required files
        requiredFiles.forEach((input) => {
            total++;
            const existing = input.getAttribute("data-existing") === "1";
            const hasNew = input.files && input.files[0];
            const ok = validateFile(input);
            if (ok && (existing || hasNew)) done++;
        });

        const pct = total ? Math.round((done / total) * 100) : 0;
        if (pct1) pct1.textContent = String(pct);
        if (pct2) pct2.textContent = String(pct);
        if (fill) fill.style.width = `${pct}%`;

        if (hint) {
            if (pct === 100)
                hint.textContent =
                    "Mantap! Data sudah lengkap. Tinggal klik Simpan.";
            else if (pct >= 70)
                hint.textContent =
                    "Hampir selesai. Lengkapi sisanya biar cepat diverifikasi.";
            else
                hint.textContent =
                    "Isi biodata & upload berkas untuk mempercepat verifikasi.";
        }

        return pct;
    }

    // file name preview (yang dropzone kamu)
    function syncFileName(input) {
        const id = input.id;
        const label = document.querySelector(`[data-file-name="${id}"]`);
        if (!label) return;
        const file = input.files && input.files[0];
        label.textContent = file ? file.name : "Belum ada file";
    }

    // listeners: fields
    requiredFields.forEach((el) => {
        el.addEventListener("input", () => {
            validateField(el);
            calcProgress();
        });
        el.addEventListener("blur", () => {
            validateField(el);
            calcProgress();
        });
        // auto digits only for nisn/nik
        const rule = el.getAttribute("data-rule");
        if (rule === "nisn" || rule === "nik") {
            el.addEventListener("input", () => {
                el.value = onlyDigits(el.value).slice(
                    0,
                    rule === "nisn" ? 10 : 16
                );
            });
        }
    });

    // listeners: files
    requiredFiles
        .concat(Array.from(form.querySelectorAll(".dashFileInput")))
        .forEach((input) => {
            input.addEventListener("change", () => {
                syncFileName(input);
                validateFile(input);
                calcProgress();
            });
        });

    // sticky submit triggers form submit
    if (btnSticky) {
        btnSticky.addEventListener("click", () => {
            // run full validation before submit
            let ok = true;
            requiredFields.forEach((el) => {
                if (!validateField(el)) ok = false;
            });
            requiredFiles.forEach((input) => {
                if (!validateFile(input)) ok = false;
            });
            calcProgress();

            if (!ok) {
                // focus first invalid
                const firstInvalid = form.querySelector(".is-invalid");
                firstInvalid?.focus?.();
                return;
            }
            form.requestSubmit(); // submit native
        });
    }

    // normal submit: prevent if invalid
    form.addEventListener("submit", (e) => {
        let ok = true;
        requiredFields.forEach((el) => {
            if (!validateField(el)) ok = false;
        });
        requiredFiles.forEach((input) => {
            if (!validateFile(input)) ok = false;
        });
        calcProgress();
        if (!ok) {
            e.preventDefault();
            const firstInvalid = form.querySelector(".is-invalid");
            firstInvalid?.focus?.();
        }
    });

    // init
    form.querySelectorAll(".dashFileInput").forEach(syncFileName);
    calcProgress();
});
