/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        body: "#F5F7FA",
        primary: "#0056b3c2",
        hover_menu: "#EFF2F6",
        black_500: "#141824",
        current: '#0056b3c2',
        last: '#82ca9d',
        view: '#D9FBD0',
        head: "#2b3445",
        main: '#0056b3c2',
      },
      fontSize: {
        ph: '13px'
      },
      transitionDuration: {
        '0': '0ms',
      },
    },
  },
  plugins: [
    require('tailwind-scrollbar'),
  ],
}

