<div class="rodape"></div>

<footer>
    <hr class="footer-line">
    <p class="footer-text">-- TransformFit 2025 &copy; Todos os direitos reservados --</p>
    <hr class="footer-line">
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script>
    gsap.from("footer", {
        opacity: 0,
        y: 20,
        duration: 1.2,
        ease: "power2.out"
    });

    const text = document.querySelector(".footer-text");
    text.addEventListener("mouseenter", () => {
        gsap.to(text, { color: "#FD5805", duration: 0.4, ease: "power2.out" });
    });
    text.addEventListener("mouseleave", () => {
        gsap.to(text, { color: "#ccc", duration: 0.4, ease: "power2.out" });
    });
</script>