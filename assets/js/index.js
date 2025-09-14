Shery.mouseFollower();
Shery.makeMagnet(".magnet");
Shery.textAnimate(".text-animate", {
  style: 2,
  y: 10,
  delay: 0.1,
  duration: 2,
  ease: "cubic-bezier(0.23, 1, 0.320, 1)",
  multiplier: 0.1,
});
Shery.hoverWithMediaCircle(".hvr", {
   videos: [
      "https://www.w3schools.com/html/mov_bbb.mp4",
      "https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4"
    ],
});

let sections = document.querySelectorAll(".fleftelm");

gsap.to(".fleftelm", {
  scrollTrigger: {
    trigger: "#fimages",
    pin: true,
    start: "top top",
    end: "+=" + (sections.length * window.innerHeight), 
    scrub: true,
  },
  y: -(100 * (sections.length - 1)) + "%", 
  ease: "power1.inOut",
});

Shery.imageEffect("#fright .images img", {
  style: 4,
  config: { onMouse: { value: 1 } },
  slideStyle: (setScroll) => {
    sections.forEach(function (section, index) {
      ScrollTrigger.create({
        trigger: section,
        start: "top top",
        scrub: 1,
        onUpdate: function (prog) {
          setScroll(prog.progress + index);
        },
      });
    });
  },
});

