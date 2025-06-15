// Handling Dropdown Click
const dropdownBtn = document.getElementById("dropdown");
const dropdownProfileList = document.getElementById("profile_list");
const dropdownIcon = document.getElementById("dropdown_icon");
dropdownBtn?.addEventListener("click", (e) => {
    e.stopPropagation();
    dropdownProfileList.classList.toggle("none");
    dropdownIcon.style.transform = dropdownProfileList.classList.contains(
        "none"
    )
        ? ""
        : "rotate(180deg";
});

document.addEventListener("click", () => {
    dropdownProfileList.classList.add("none");
    dropdownIcon.style.transform = "";
});

// Handling Nav Links For Small Devices
const collapseBtn = document.getElementById("collapse_btn");
const navLinks = document.getElementById("nav_links");
collapseBtn.addEventListener("click", () => {
    collapseBtn.classList.toggle("active");
    navLinks.classList.toggle("active");
});

// Handling Fade In Effect
const faders = document.querySelectorAll(".fade-in");
const observer = new IntersectionObserver(
    (entries, observer) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                entry.target.style.transitionDelay = `${index * 0.1}s`;
                entry.target.classList.add("show");
                observer.unobserve(entry.target);
            }
        });
    },
    { threshold: 0.1 }
);
faders.forEach((el) => observer.observe(el));

// Handle Form Label Effect
const formGroups = document.querySelectorAll(".form-group");
formGroups.forEach((formGroup) => {
    const input = formGroup.querySelector("input");
    const textarea = formGroup.querySelector("textarea");
    const label = formGroup.querySelector("label");
    if (input) {
        input.value.length > 0
            ? label.classList.add("active")
            : label.classList.remove("active");
        input.onchange = (e) =>
            e.target.value.length > 0
                ? label.classList.add("active")
                : label.classList.remove("active");
    }
    if (textarea) {
        textarea.value.length > 0
            ? label.classList.add("active")
            : label.classList.remove("active");
        textarea.onchange = (e) =>
            e.target.value.length > 0
                ? label.classList.add("active")
                : label.classList.remove("active");
    }
});
