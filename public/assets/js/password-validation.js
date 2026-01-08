/**
 * GLOBAL PASSWORD VALIDATION
 * ----------------------------------
 * - Min 12 characters
 * - Uppercase, lowercase
 * - Number & symbol
 */

window.PasswordValidator = (function () {
    let states = {};

    function validate(value) {
        const errors = [];

        if (value.length < 12) errors.push("Minimum 12 characters");
        if (!/[a-z]/.test(value)) errors.push("At least 1 lowercase letter");
        if (!/[A-Z]/.test(value)) errors.push("At least 1 uppercase letter");
        if (!/[0-9]/.test(value)) errors.push("At least 1 number");
        if (!/[@$!%*#?&^()_\-+=]/.test(value)) errors.push("At least 1 symbol");

        return errors;
    }

    function bind(options) {
        const { inputId, errorId, formSelector, required = true } = options;

        const input = document.getElementById(inputId);
        const errorBox = document.getElementById(errorId);
        const form = document.querySelector(formSelector);

        if (!input || !errorBox || !form) return;

        states[inputId] = !required;

        input.addEventListener("input", () => {
            const value = input.value.trim();

            if (!required && value === "") {
                reset(input, errorBox);
                states[inputId] = true;
                return;
            }

            const errors = validate(value);

            if (errors.length) {
                input.classList.add("is-invalid");
                errorBox.classList.remove("d-none");
                errorBox.innerHTML = errors.map((e) => `• ${e}`).join("<br>");
                states[inputId] = false;
            } else {
                reset(input, errorBox);
                states[inputId] = true;
            }
        });

        form.addEventListener("submit", (e) => {
            if (!states[inputId]) {
                e.preventDefault();
                Swal.fire({
                    icon: "error",
                    title: "Invalid Password",
                    text: "Password does not meet the required criteria.",
                });
            }
        });
    }

    function reset(input, errorBox) {
        input.classList.remove("is-invalid");
        errorBox.classList.add("d-none");
    }

    return {
        bind,
    };
})();
