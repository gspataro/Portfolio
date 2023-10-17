/** @type {import('tailwindcss').Config} */

const plugin = require('tailwindcss/plugin')

module.exports = {
  content: ["./contents/view/**/*.html"],
  theme: {
    fontFamily: {
        "sans": ['Roboto', 'Sans-Serif', 'Arial'],
        "roboto-flex": ['Roboto Flex', 'Roboto', 'Sans-Serif', 'Arial']
    },
    colors: {
        "transparent": "transparent",
        "black": "#000000",
        "white": "#ffffff",
        "thunder": {
            "lightest": "#656465",
            "lighter": "#4f4d4f",
            "light": "#434143",
            DEFAULT: "#393739",
            "dark": "#232123",
            "darker": "#191719",
            "darkest": "#121112"

        },
        "stiletto": {
            "lightest": "#cd625f",
            "lighter": "#c44441",
            "light": "#b13735",
            DEFAULT: "#9a2e2c",
            "dark": "#882826",
            "darker": "#7c2523",
            "darkest": "#6c2220"
        },
        "fawn": {
            "lightest": "#ac7e6d",
            "lighter": "#a16b58",
            "light": "#955943",
            DEFAULT: "#89462E",
            "dark": "#7b3f29",
            "darker": "#6e3825",
            "darkest": "#603120"
        },
        "brass": {
            "lightest": "#d9ad8d",
            "lighter": "#d4a17d",
            "light": "#ce966c",
            DEFAULT: "#C98A5C",
            "dark": "#b57c53",
            "darker": "#a16e4a",
            "darkest": "#8d6140"
        },
        "ablescent": {
            "lightest": "#f9f2e2",
            "lighter": "#f8f1dd",
            "light": "#f7efd9",
            DEFAULT: "#F6EDD5",
            "dark": "#ddd5c0",
            "darker": "#c5beaa",
            "darkest": "#aca695"
        }
    },
    spacing: {
        DEFAULT: "0",
        "3xs": "0.25rem",
        "2xs": "0.5rem",
        "xs": "1rem",
        "sm": "1.5rem",
        "md": "2rem",
        "lg": "3rem",
        "xl": "5rem",
        "2xl": "7rem",
        "3xl": "9rem"
    },
    screens: {
        "tablet": "768px",
        "laptop": "1024px",
        "desktop": "1280px"
    },
    container: {
        center: true,
        padding: {
            DEFAULT: "1rem",
            "tablet": "1.5rem",
            "desktop": "2rem"
        }
    },
    extend: {
        animation: {
            nogravity: 'nogravity 25s linear infinite',
            nogravitynegative: 'nogravitynegative 25s linear infinite'
        },
        keyframes: {
            nogravity: {
                "0%": {
                    transform: "translateY(0) translateX(0) rotate(0deg)",
                    opacity: 1,
                    "border-radius": 0
                },
                "100%": {
                    transform: "translateY(-1000px) translateX(500px) rotate(720deg)",
                    opacity: 0,
                    "border-radius": 5
                }
            },
            nogravitynegative: {
                "0%": {
                    transform: "translateY(0) translateX(0) rotate(0deg)",
                    opacity: 1,
                    "border-radius": 0
                },
                "100%": {
                    transform: "translateY(-1000px) translateX(-500px) rotate(720deg)",
                    opacity: 0,
                    "border-radius": 5
                }
            }
        }
    },
  },
  plugins: [
    plugin(function({addBase, theme}) {
        addBase({
            "h1": {
                fontSize: "2.125rem",
                fontWeight: 400
            },
            "h2": {
                fontSize: "2rem",
                fontWeight: 400
            },
            "h3": {
                fontSize: "1.875rem",
                fontWeight: 400
            },
            "h4": {
                fontSize: "1.75rem",
                fontWeight: 400
            },
            "h5": {
                fontSize: "1.625rem",
                fontWeight: 400
            },
            "h6": {
                fontSize: "1.5rem",
                fontWeight: 400
            },
            "a": {
                color: theme('colors.stiletto.DEFAULT'),
                textDecoration: 'underline'
            }
        })
    })
  ],
}
