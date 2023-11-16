/** @type {import('tailwindcss').Config} */

const plugin = require('tailwindcss/plugin')

module.exports = {
  content: ["./contents/view/**/*.html", "./contents/view/**/*.js"],
  darkMode: 'class',
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
            "lightest": "#F9D5B6",
            "lighter": "#F7C192",
            "light": "#F4B379",
            DEFAULT: "#F2A25C",
            "dark": "#EB8C38",
            "darker": "#D77219",
            "darkest": "#B45F14"
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
    fontSize: {
        DEFAULT: "1.125rem",
        "3xl": "2.2rem",
        "2xl": "2rem",
        "xl": "1.6rem",
        "lg": "1.4rem",
        "md": "1.250rem",
        "sm": "1.125rem",
        "xs": "1rem",
        "2xs": "0.9rem",
        "3xs": "0.8rem"
    },
    screens: {
        "tablet-v": "768px",
        "tablet-h": "992px",
        "laptop-sm": "1280px",
        "laptop-lg": "1440px",
        "desktop": "1920px"
    },
    container: {
        center: true,
        padding: {
            DEFAULT: "1rem",
            "tablet": "1.5rem",
            "desktop": "2rem"
        },
        screens: {
            "tablet-v": "768px",
            "tablet-h": "992px",
            "laptop-sm": "1232px",
            "laptop-lg": "1392px",
            "desktop": "1500px"
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
    plugin(function({addBase, addComponents, theme}) {
        addBase({
            body: {
                backgroundColor: theme('colors.ablescent.lightest'),
                color: theme('colors.thunder.darkest'),
                fontSize: theme('fontSize.DEFAULT'),
                fontWeight: 300
            },
            h1: {
                fontSize: theme('fontSize.3xl'),
                fontWeight: 400
            },
            h2: {
                fontSize: theme('fontSize.2xl'),
                fontWeight: 400
            },
            h3: {
                fontSize: theme('fontSize.xl'),
                fontWeight: 400
            },
            h4: {
                fontSize: theme('fontSize.lg'),
                fontWeight: 400
            },
            h5: {
                fontSize: theme('fontSize.md'),
                fontWeight: 400
            },
            h6: {
                fontSize: theme('fontSize.sm'),
                fontWeight: 400
            },
            a: {
                color: theme('colors.stiletto.DEFAULT'),
                textDecoration: 'underline'
            },
            ".dark": {
                body: {
                    backgroundColor: theme('colors.thunder.darkest'),
                    color: theme('colors.ablescent.lightest')
                },
                a: {
                    color: theme('colors.brass.DEFAULT')
                }
            }
        })

        addComponents({
            ".prose": {
                "h1, h2, h3, h4, h5, h6": {
                    marginTop: theme('spacing.md'),
                    marginBottom: theme('spacing.sm'),
                    "&:first-child": {
                        marginTop: 0
                    },
                    "&:last-child": {
                        marginBottom: 0
                    }
                },
                p: {
                    marginTop: theme('spacing.xs'),
                    marginBottom: theme('spacing.xs'),
                    "&:first-child": {
                        marginTop: 0
                    },
                    "&:last-child": {
                        marginBottom: 0
                    }
                },
                ul: {
                    marginTop: theme('spacing.xs'),
                    marginBottom: theme('spacing.xs'),
                    paddingLeft: '2rem',
                    listStyleType: 'disc',
                    "&:first-child": {
                        marginTop: 0
                    },
                    "&:last-child": {
                        marginBottom: 0
                    }
                }
            }
        })
    })
  ],
}
