/** @type {import('tailwindcss').Config} */
export default {
  content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
  theme: {
    extend: {
      fontSize: {
        react9xl: "clamp(0.75rem, -1.067rem + 9.084vw, 8rem)",
        react8xl: "clamp(0.75rem, -0.566rem + 6.578vw, 6rem)",
        react7xl: "clamp(0.75rem, -0.19rem + 4.699vw, 4.5rem)",
        react6xl: "clamp(0.75rem, -0.002rem + 3.759vw, 3.75rem)",
        react5xl: "clamp(0.75rem, 0.186rem + 2.819vw, 3rem)",
        react4xl: "clamp(0.75rem, 0.374rem + 1.879vw, 2.25rem)",

        "4xl-xl": "clamp(1.25rem, 0.999rem + 1.253vw, 2.25rem)",

        "3xl-xl": "clamp(1.25rem, 1.093rem + 0.783vw, 1.875rem)",
        "3xl-xs": "clamp(1.125rem, 0.937rem + 0.94vw, 1.875rem)",

        "2xl-lg": "clamp(18px, 4px + 1vw, 24px)",

        react2xl: "clamp(0.75rem, 0.562rem + 0.94vw, 1.5rem)",
        reactxl: "clamp(0.75rem, 0.625rem + 0.626vw, 1.25rem)",
        reactlg: "clamp(0.75rem, 0.656rem + 0.47vw, 1.125rem)",
        reactbase: "clamp(0.75rem, 0.687rem + 0.313vw, 1rem)",
        reactsm: "clamp(0.75rem, 0.719rem + 0.157vw, 0.875rem)",
        reactxs: "clamp(0.75rem, 0.75rem + 0vw, 0.75rem)",
      },
      width: {
        reactxl: "clamp(12px, 2vh + 12px, 32px)",
      },
    },
    screens: {
      "8xl": { max: "1800px" },
      "7xl": { max: "1700px" },
      "6xl": { max: "1600px" },
      "5xl": { max: "1500px" },
      "4xl": { max: "1400px" },
      "3xl": { max: "1300px" },
      "2xl": { max: "1200px" },
      xl: { max: "1100px" },
      lg: { max: "1024px" },
      md: { max: "800px" },
      sm: { max: "600px" },
      xs: { max: "360px" },
    },
    boxShadow: {
      sm: " rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px",
      shadow: "rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px",
      md: "rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px",
      lg: "rgba(0, 0, 0, 0.15) 0px 3px 3px 0px",
    },
  },
  plugins: [],
};
