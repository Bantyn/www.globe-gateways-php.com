

document.addEventListener("DOMContentLoaded", function () {
  gsap.registerPlugin(ScrollTrigger);
  Shery.mouseFollower();
  Shery.makeMagnet(".magnet");

  Shery.textAnimate(".text-animate", {
    style: 2,
    stagger: 0.1,
    y: 10,
    delay: 0.1,
    duration: 2,
    ease: "cubic-bezier(0.23, 1, 0.320, 1)",
    multiplier: 0.1,
  });

  Shery.hoverWithMediaCircle(".hvr", {
    videos: [
      "../assets/video/0.mp4",
      "../assets/video/3.mp4",
    ],
  });
  const sections = gsap.utils.toArray(".fleftelm");
  const wrapper = document.querySelector(".left-wrap") || document.querySelector("#fimages .left-wrap") || document.querySelector("#fimages");
  if (!sections.length || !wrapper) {
    console.warn("Scroll setup: .fleftelm or wrapper (#fimages/.left-wrap) not found", { sectionsCount: sections.length, wrapper });
    return;
  }
  const totalScroll = window.innerHeight * (sections.length - 1);
  gsap.to(".fleftelm", {
    yPercent: -100 * (sections.length - 1),
    ease: "none",
    scrollTrigger: {
      trigger: "#fimages",
      start: "top top",
      end: () => `+=${totalScroll}`,
      scrub: 1,
      pin: true,
      anticipatePin: 1
    }
  });
  Shery.imageEffect(".images", {
    style: 6,
    config: { onMouse: { value: 1 } },
    slideStyle: function (setScroll) {
      sections.forEach(function (section, index) {
        ScrollTrigger.create({
          trigger: section,
          start: "top top",
          end: "bottom top",
          scrub: 1,
          onUpdate: function (self) {
            setScroll(self.progress + index);
          }
        });
      });
    },
  });
  window.addEventListener("resize", () => {
    ScrollTrigger.refresh();
  });
});
document.addEventListener("DOMContentLoaded", function () {
  gsap.registerPlugin(ScrollTrigger);
  gsap.utils.toArray(".home-main").forEach((section, i) => {
    gsap.from(section.querySelectorAll("p, h1, .small-desc"), {
      opacity: 0,
      y: 50,
      duration: 1.2,
      stagger: 0.2,
      ease: "power3.out",
      scrollTrigger: {
        trigger: section,
        start: "top 80%",
        toggleActions: "play none none reverse",
        scrub: 1,
      }
    });
  });
  Shery.hoverWithMediaCircle(".hvr", {
    videos: ["../assets/video/0.mp4", "../assets/video/3.mp4"],
  });
});

// document.querySelectorAll("a").forEach(a => {
//   a.addEventListener("click", e => {
//     e.preventDefault();
//   });
// });
