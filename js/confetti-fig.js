var end = Date.now() + (8 * 1000);
var colors = ['#d5202f', '#47c0ef', '#154b9d', '#ffffff'];
var canvas = document.getElementById('confetti-canvas');
canvas.confetti = canvas.confetti || confetti.create(canvas, { resize: true });

(function frame() {
  confetti({
    particleCount: 4,
    angle: 60,
    spread: 55,
    origin: { x: 0 },
    colors: colors
  });
  confetti({
    particleCount: 4,
    angle: 120,
    spread: 55,
    origin: { x: 1 },
    colors: colors
  });

  if (Date.now() < end) {
    requestAnimationFrame(frame);
  }
}());