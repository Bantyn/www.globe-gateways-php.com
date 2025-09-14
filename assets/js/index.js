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

let sections = document.querySelectorAll(".fleftelm");

gsap.to(".fleftelm", {
  scrollTrigger: {
    trigger: "#fimages",
    pin: true,
    start: "top top",
    end: "+=" + (sections.length * window.innerHeight), 
    end: "+=" + (window.innerHeight * (sections.length - 1)),
    scrub: 1,
  },
  y: -(200 * (sections.length - 1)) + "%", 
  ease: "power1.inOut",
});


Shery.imageEffect(".images", {
  style: 5,
  config: { onMouse: { value: 1 } },

  slideStyle: function(setScroll) {
    sections.forEach(function(section, index) {
      ScrollTrigger.create({
        trigger: section,
        start: "top top",
        onUpdate: function (prog) {
          console.log(prog.progress);
          setScroll(prog.progress, index);
        }
      });
    });
  }
});

