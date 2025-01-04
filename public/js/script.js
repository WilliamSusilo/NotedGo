// The Fiture for Navigate into Different Page
window.onload = function () {
  // Snow Effect on Website
  const snow = document.querySelector(".snow");
  if (snow) {
    snowFall.snow(snow, {
      round: true,
      minSize: 1,
      maxSize: 7,
      shadow: true,
      flakeCount: 10,
      flakeColor: "white",
    });
  }
};
