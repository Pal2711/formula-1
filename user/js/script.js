console.log('F1 homepage clone JS loaded.');

// Utility function for slider setup
function setupSlider(containerSelector, trackSelector, leftArrowSelector, rightArrowSelector) {
  const container = document.querySelector(containerSelector);
  if (!container) return;
  const track = container.querySelector(trackSelector);
  const left = container.querySelector(leftArrowSelector);
  const right = container.querySelector(rightArrowSelector);
  if (!track || !left || !right) return;

  left.addEventListener('click', () => {
    const item = track.children[0];
    if (item) track.scrollBy({ left: -item.offsetWidth - 16, behavior: 'smooth' });
  });

  right.addEventListener('click', () => {
    const item = track.children[0];
    if (item) track.scrollBy({ left: item.offsetWidth + 16, behavior: 'smooth' });
  });
}

// Main DOMContentLoaded handler - consolidated to prevent duplicates
document.addEventListener('DOMContentLoaded', function () {
  // Basic sliders
  setupSlider('.stories .slider-container', '.slider-track', '.slider-arrow.left', '.slider-arrow.right');
  setupSlider('.drivers .slider-container', '.slider-track', '.slider-arrow.left', '.slider-arrow.right');

  // Car Gallery Slider Logic
    const carSliderTrack = document.querySelector('.car-slider-track');
    const carSliderImages = carSliderTrack ? carSliderTrack.querySelectorAll('img') : [];
    const carSliderLeft = document.querySelector('.car-slider-arrow.left');
    const carSliderRight = document.querySelector('.car-slider-arrow.right');

    if (carSliderTrack && carSliderImages.length > 0) {
        // Get the width of one image (including margin/gap)
        const slideWidth = carSliderImages[0].offsetWidth + 24; // 24px is approx gap, adjust if needed
        const scrollAmount = slideWidth * 1.5; // <-- Change here

        carSliderLeft.addEventListener('click', function () {
            carSliderTrack.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        });

        carSliderRight.addEventListener('click', function () {
            carSliderTrack.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });
    }

    // Autoplay logic for car gallery
    let carAutoPlayInterval;
    let carIsHovered = false;
    function startCarAutoPlay() {
      carAutoPlayInterval = setInterval(() => {
        if (!carIsHovered) {
          if (Math.abs(carSliderTrack.scrollLeft + carSliderTrack.offsetWidth - carSliderTrack.scrollWidth) < 1) {
            carSliderTrack.scrollTo({ left: 0, behavior: 'smooth' });
          } else {
            carSliderTrack.scrollBy({ left: 300, behavior: 'smooth' });
          }
        }
      }, 3000);
    }
    function stopCarAutoPlay() {
      clearInterval(carAutoPlayInterval);
    }
    carSliderTrack.addEventListener('mouseenter', function () {
      carIsHovered = true;
      stopCarAutoPlay();
    });
    carSliderTrack.addEventListener('mouseleave', function () {
      carIsHovered = false;
      startCarAutoPlay();
    });
    startCarAutoPlay();
});
  // F1 DRIVERS Slider Logic
  const driversSliderTrack = document.querySelector('.drivers-slider-track');
  const driversSliderLeft = document.querySelector('.drivers-slider-arrow.left');
  const driversSliderRight = document.querySelector('.drivers-slider-arrow.right');
  if (driversSliderTrack && driversSliderLeft && driversSliderRight) {
    const scrollAmount = 100; // px to scroll per click/autoplay
    const autoplayInterval = 5000; // ms

    driversSliderLeft.addEventListener('click', function () {
      driversSliderTrack.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    });
    driversSliderRight.addEventListener('click', function () {
      driversSliderTrack.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    });

    // Autoplay logic
    let autoPlayInterval;
    let isHovered = false;
    function startAutoPlay() {
      autoPlayInterval = setInterval(() => {
        if (!isHovered) {
          // If at end, scroll to start
          if (Math.abs(driversSliderTrack.scrollLeft + driversSliderTrack.offsetWidth - driversSliderTrack.scrollWidth) < 5) {
            driversSliderTrack.scrollTo({ left: 0, behavior: 'smooth' });
          } else {
            driversSliderTrack.scrollBy({ left: scrollAmount, behavior: 'smooth' });
          }
        }
      }, autoplayInterval);
    }
    function stopAutoPlay() {
      clearInterval(autoPlayInterval);
    }
    driversSliderTrack.addEventListener('mouseenter', function () {
      isHovered = true;
      stopAutoPlay();
    });
    driversSliderTrack.addEventListener('mouseleave', function () {
      isHovered = false;
      startAutoPlay();
    });
    startAutoPlay();
  }

  // 360 Car View Logic
  const carImages = [
    'images/f1 (1).jpg',
    'images/f1 (2).jpg',
    'images/f1 (3).jpg',
    'images/f1 (4).jpg'
  ];

  let carIndex = 0;
  const carImg = document.getElementById('car360-img');
  const prevBtn = document.getElementById('car360-prev');
  const nextBtn = document.getElementById('car360-next');

  function fadeCarImage(newSrc) {
    if (!carImg) return;
    carImg.style.opacity = 0.2;
    setTimeout(() => {
      carImg.src = newSrc;
      carImg.onload = () => {
        carImg.style.opacity = 1;
      };
    }, 200);
  }

  if (carImg && prevBtn && nextBtn) {
    prevBtn.addEventListener('click', function () {
      carIndex = (carIndex - 1 + carImages.length) % carImages.length;
      fadeCarImage(carImages[carIndex]);
    });

    nextBtn.addEventListener('click', function () {
      carIndex = (carIndex + 1) % carImages.length;
      fadeCarImage(carImages[carIndex]);
    });

    // Mouse drag control
    let isDragging = false;
    let startX = 0;

    carImg.addEventListener('mousedown', function (e) {
      isDragging = true;
      startX = e.clientX;
      carImg.style.cursor = 'grabbing';
    });

    document.addEventListener('mousemove', function (e) {
      if (!isDragging) return;
      const dx = e.clientX - startX;
      if (Math.abs(dx) > 20) {
        if (dx > 0) {
          carIndex = (carIndex - 1 + carImages.length) % carImages.length;
        } else {
          carIndex = (carIndex + 1) % carImages.length;
        }
        fadeCarImage(carImages[carIndex]);
        startX = e.clientX;
      }
    });

    document.addEventListener('mouseup', function () {
      isDragging = false;
      carImg.style.cursor = 'grab';
    });

    carImg.style.cursor = 'grab';
  }

  // Fullscreen functionality
  const car360Section = document.getElementById('car360-section');
  const fsBtn = document.getElementById('car360-fullscreen');

  if (car360Section && fsBtn) {
    fsBtn.addEventListener('click', function () {
      if (document.fullscreenElement) {
        document.exitFullscreen();
      } else {
        if (car360Section.requestFullscreen) {
          car360Section.requestFullscreen();
        } else if (car360Section.webkitRequestFullscreen) {
          car360Section.webkitRequestFullscreen();
        } else if (car360Section.msRequestFullscreen) {
          car360Section.msRequestFullscreen();
        }
      }
    });

    document.addEventListener('fullscreenchange', function () {
      if (document.fullscreenElement === car360Section) {
        car360Section.classList.add('car360-fullscreen');
        fsBtn.textContent = 'Exit Full Screen';
      } else {
        car360Section.classList.remove('car360-fullscreen');
        fsBtn.textContent = 'Full Screen';
      }
    });
  }

  // Optional: Add arrow scroll for stories section
  document.addEventListener('DOMContentLoaded', function() {
      const storiesScroll = document.querySelector('.stories-scroll');
      if (!storiesScroll) return;

      // Create left/right buttons
      const leftBtn = document.createElement('button');
      leftBtn.innerHTML = '&#8592;';
      leftBtn.className = 'stories-arrow stories-arrow-left';
      const rightBtn = document.createElement('button');
      rightBtn.innerHTML = '&#8594;';
      rightBtn.className = 'stories-arrow stories-arrow-right';

      storiesScroll.parentElement.appendChild(leftBtn);
      storiesScroll.parentElement.appendChild(rightBtn);

      leftBtn.onclick = () => {
          storiesScroll.scrollBy({ left: -300, behavior: 'smooth' });
      };
      rightBtn.onclick = () => {
          storiesScroll.scrollBy({ left: 300, behavior: 'smooth' });
      };
  });

  // --- Amazing Effects: Features fade-in on scroll ---
  const features = document.querySelectorAll('.feature');
  function revealFeatures() {
    const triggerBottom = window.innerHeight * 0.92;
    features.forEach((feature, i) => {
      const boxTop = feature.getBoundingClientRect().top;
      if (boxTop < triggerBottom) {
        feature.classList.add('visible');
      }
    });
  }
  window.addEventListener('scroll', revealFeatures);
  revealFeatures();

  // --- Amazing Effects: Sticky navbar shadow on scroll ---
  const header = document.querySelector('header');
  function handleStickyHeader() {
    if (window.scrollY > 10) {
      header.classList.add('sticky');
    } else {
      header.classList.remove('sticky');
    }
  }
  window.addEventListener('scroll', handleStickyHeader);
  handleStickyHeader();
;

// About us section
// js/script.js

// Smooth scroll for internal links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();

    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  });
});

// Add scroll reveal effect for About section 
const aboutElements = document.querySelectorAll('.about-section h2, .about-section h3, .about-section p, .about-section ul li');

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.animationPlayState = 'running';
    }
  });
}, {
  threshold: 0.2
});

aboutElements.forEach(el => {
  observer.observe(el);
});

// Car Gallery Slider Autoplay and Arrow Controls
document.addEventListener('DOMContentLoaded', function () {
  const track = document.getElementById('car-slider-track');
  const btnLeft = document.getElementById('car-slider-left');
  const btnRight = document.getElementById('car-slider-right');
  const scrollAmount = 100; // px to scroll per click/autoplay
  const autoplayInterval = 5000; // ms

  let autoplay;

  function scrollRight() {
    if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 5) {
      track.scrollTo({ left: 0, behavior: 'smooth' });
    } else {
      track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
  }

  function scrollLeft() {
    if (track.scrollLeft <= 0) {
      track.scrollTo({ left: track.scrollWidth, behavior: 'smooth' });
    } else {
      track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    }
  }

  btnRight.addEventListener('click', () => {
    scrollRight();
    resetAutoplay();
  });

  btnLeft.addEventListener('click', () => {
    scrollLeft();
    resetAutoplay();
  });

  function startAutoplay() {
    autoplay = setInterval(scrollRight, autoplayInterval);
  }

  function resetAutoplay() {
    clearInterval(autoplay);
    startAutoplay();
  }

  track.addEventListener('mouseenter', () => clearInterval(autoplay));
  track.addEventListener('mouseleave', startAutoplay);

  startAutoplay();
});

// F1 Drivers Slider Autoplay and Arrow Controls
document.addEventListener('DOMContentLoaded', function () {
  const track = document.getElementById('drivers-slider-track');
  const btnLeft = document.getElementById('drivers-slider-left');
  const btnRight = document.getElementById('drivers-slider-right');
  const scrollAmount = 200; // px to scroll per click/autoplay
  const autoplayInterval = 3500; // ms

  if (!track || !btnLeft || !btnRight) return; // If not present, skip

  let autoplay;

  function scrollRight() {
    if (track.scrollLeft + track.clientWidth >= track.scrollWidth - 5) {
      track.scrollTo({ left: 0, behavior: 'smooth' });
    } else {
      track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
  }

  function scrollLeft() {
    if (track.scrollLeft <= 0) {
      track.scrollTo({ left: track.scrollWidth, behavior: 'smooth' });
    } else {
      track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    }
  }

  btnRight.addEventListener('click', () => {
    scrollRight();
    resetAutoplay();
  });

  btnLeft.addEventListener('click', () => {
    scrollLeft();
    resetAutoplay();
  });

  function startAutoplay() {
    autoplay = setInterval(scrollRight, autoplayInterval);
  }

  function resetAutoplay() {
    clearInterval(autoplay);
    startAutoplay();
  }

  track.addEventListener('mouseenter', () => clearInterval(autoplay));
  track.addEventListener('mouseleave', startAutoplay);

  startAutoplay();
});

document.addEventListener('DOMContentLoaded', function () {
  const carTrack = document.getElementById('car-slider-track');
  const carLeft = document.getElementById('car-slider-left');
  const carRight = document.getElementById('car-slider-right');
  const scrollAmount = 400; // px to scroll per click/autoplay
  const autoplayInterval = 4000; // ms

  if (carTrack && carLeft && carRight) {
    let autoplay;

    function scrollRight() {
      if (carTrack.scrollLeft + carTrack.clientWidth >= carTrack.scrollWidth - 5) {
        carTrack.scrollTo({ left: 0, behavior: 'smooth' });
      } else {
        carTrack.scrollBy({ left: scrollAmount, behavior: 'smooth' });
      }
    }

    function scrollLeft() {
      if (carTrack.scrollLeft <= 0) {
        carTrack.scrollTo({ left: carTrack.scrollWidth, behavior: 'smooth' });
      } else {
        carTrack.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
      }
    }

    carRight.addEventListener('click', () => {
      scrollRight();
      resetAutoplay();
    });

    carLeft.addEventListener('click', () => {
      scrollLeft();
      resetAutoplay();
    });

    function startAutoplay() {
      autoplay = setInterval(scrollRight, autoplayInterval);
    }

    function resetAutoplay() {
      clearInterval(autoplay);
      startAutoplay();
    }

    carTrack.addEventListener('mouseenter', () => clearInterval(autoplay));
    carTrack.addEventListener('mouseleave', startAutoplay);

    startAutoplay();
  }
});

// Drivers Slider
const driversTrack = document.getElementById('drivers-slider-track');
const driversLeft = document.getElementById('drivers-slider-left');
const driversRight = document.getElementById('drivers-slider-right');

if (driversTrack && driversLeft && driversRight) {
  driversLeft.addEventListener('click', () => {
    driversTrack.scrollBy({ left: -340, behavior: 'smooth' });
  });
  driversRight.addEventListener('click', () => {
    driversTrack.scrollBy({ left: 340, behavior: 'smooth' });
  });
}

// Car Gallery Slider
const carTrack = document.getElementById('car-slider-track');
const carLeft = document.getElementById('car-slider-left');
const carRight = document.getElementById('car-slider-right');

if (carTrack && carLeft && carRight) {
  carLeft.addEventListener('click', () => {
    carTrack.scrollBy({ left: -410, behavior: 'smooth' });
  });
  carRight.addEventListener('click', () => {
    carTrack.scrollBy({ left: 410, behavior: 'smooth' });
  });
}

document.addEventListener('DOMContentLoaded', function() {
  const driversTab = document.getElementById('drivers-tab');
  const teamsTab = document.getElementById('teams-tab');
  const driversLeaderboard = document.getElementById('drivers-leaderboard');
  const teamsLeaderboard = document.getElementById('teams-leaderboard');

  if (driversTab && teamsTab && driversLeaderboard && teamsLeaderboard) {
    driversTab.addEventListener('click', function() {
      driversLeaderboard.style.display = '';
      teamsLeaderboard.style.display = 'none';
      driversTab.classList.add('active');
      driversTab.style.color = '#fff';
      driversTab.style.borderBottom = '4px solid #ff1e1e';
      teamsTab.classList.remove('active');
      teamsTab.style.color = '#b0b8c1';
      teamsTab.style.borderBottom = 'none';
    });
    teamsTab.addEventListener('click', function() {
      driversLeaderboard.style.display = 'none';
      teamsLeaderboard.style.display = '';
      teamsTab.classList.add('active');
      teamsTab.style.color = '#fff';
      teamsTab.style.borderBottom = '4px solid #ff1e1e';
      driversTab.classList.remove('active');
      driversTab.style.color = '#b0b8c1';
      driversTab.style.borderBottom = 'none';
    });
  }
});

document.addEventListener('DOMContentLoaded', function() {
  const track = document.querySelector('.reachout-slider-track');
  const cards = document.querySelectorAll('.reachout-card');
  const leftBtn = document.querySelector('.reachout-arrow.left');
  const rightBtn = document.querySelector('.reachout-arrow.right');
  const cardsPerView = 3;
  let currentIndex = 0;

  function updateSlider() {
    const cardWidth = cards[0].offsetWidth + 16; // card width + margin
    track.style.transform = `translateX(-${currentIndex * cardWidth}px)`;
  }

  rightBtn.addEventListener('click', function() {
    if (currentIndex < cards.length - cardsPerView) {
      currentIndex++;
      updateSlider();
    }
  });

  leftBtn.addEventListener('click', function() {
    if (currentIndex > 0) {
      currentIndex--;
      updateSlider();
    }
  });

  // Responsive: reset on resize
  window.addEventListener('resize', updateSlider);

  updateSlider();
});

// Drag-to-scroll for testimonials slider
document.addEventListener('DOMContentLoaded', function() {
  const track = document.getElementById('reachout-slider-track');
  if (!track) return;

  let isDown = false;
  let startX;
  let scrollLeft;

  // Mouse events
  track.addEventListener('mousedown', (e) => {
    isDown = true;
    track.classList.add('dragging');
    startX = e.pageX - track.offsetLeft;
    scrollLeft = track.scrollLeft;
  });
  track.addEventListener('mouseleave', () => {
    isDown = false;
    track.classList.remove('dragging');
  });
  track.addEventListener('mouseup', () => {
    isDown = false;
    track.classList.remove('dragging');
  });
  track.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - track.offsetLeft;
    const walk = (x - startX) * 1.5; // scroll-fastness
    track.scrollLeft = scrollLeft - walk;
  });

  // Touch events for mobile
  track.addEventListener('touchstart', (e) => {
    isDown = true;
    startX = e.touches[0].pageX - track.offsetLeft;
    scrollLeft = track.scrollLeft;
  });
  track.addEventListener('touchend', () => {
    isDown = false;
  });
  track.addEventListener('touchmove', (e) => {
    if (!isDown) return;
    const x = e.touches[0].pageX - track.offsetLeft;
    const walk = (x - startX) * 1.5;
    track.scrollLeft = scrollLeft - walk;
  });
});

window.addEventListener('load', function() {
  var loader = document.getElementById('f1-loader-overlay');
  loader.classList.add('fade-out');
  setTimeout(function() {
    loader.style.display = 'none';
  }, 1000); // 2 seconds
});

// Car Gallery Slider Arrow Controls + Autoplay
(function() {
  const leftBtn = document.getElementById('car-slider-left');
  const rightBtn = document.getElementById('car-slider-right');
  const track = document.getElementById('car-slider-track');
  if (!leftBtn || !rightBtn || !track) return;
  const img = track.querySelector('img');
  const scrollAmount = img ? img.offsetWidth + 30 : 400; // 30px for gap/padding

  let autoPlayInterval;
  let autoPlayPaused = false;
  let autoPlayResumeTimeout;

  function scrollRight() {
    track.scrollBy({ left: scrollAmount, behavior: 'smooth' });
  }
  function scrollLeft() {
    track.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
  }
  function startAutoPlay() {
    autoPlayInterval = setInterval(() => {
      if (!autoPlayPaused) {
        // If at end, scroll to start
        if (Math.abs(track.scrollLeft + track.offsetWidth - track.scrollWidth) < 5) {
          track.scrollTo({ left: 0, behavior: 'smooth' });
        } else {
          scrollRight();
        }
      }
    }, 1000);
  }
  function pauseAutoPlay() {
    autoPlayPaused = true;
    clearInterval(autoPlayInterval);
    clearTimeout(autoPlayResumeTimeout);
    autoPlayResumeTimeout = setTimeout(() => {
      autoPlayPaused = false;
      startAutoPlay();
    }, 5000); // resume after 5s
  }

  leftBtn.addEventListener('click', () => {
    scrollLeft();
    pauseAutoPlay();
  });
  rightBtn.addEventListener('click', () => {
    scrollRight();
    pauseAutoPlay();
  });
  track.addEventListener('mouseenter', pauseAutoPlay);
  track.addEventListener('mouseleave', () => {
    autoPlayPaused = false;
    startAutoPlay();
  });

  startAutoPlay();
})();




