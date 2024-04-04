/** @type {import('tailwindcss').Config} */

const plugin = require('tailwindcss/plugin')

module.exports = {
  content: ["./contents/view/**/*.html", "./contents/view/**/*.js"],
  theme: {
    fontFamily: {
        "sans": ['Roboto', 'Sans-Serif', 'Arial'],
        "roboto": ['Roboto', 'Sans-Serif', 'Arial'],
        "roboto-flex": ['Roboto Flex', 'Sans-Serif', 'Arial'],
        "oswald": ['Oswald', 'Sans-Serif', 'Arial']
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
            "lightest": "#CD625F",
            "lighter": "#C44441",
            "light": "#B13735",
            DEFAULT: "#9A2E2C",
            "dark": "#882826",
            "darker": "#7C2523",
            "darkest": "#6C2220"
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
        "ivory": {
            "lightest": "#FFFFF8",
            "lighter": "#FFFFF5",
            "light": "#FFFFF2",
            DEFAULT: "#FFFFF0",
            "dark": "#E6E6D8",
            "darker": "#CCCCC0",
            "darkest": "#B3B3A8"
        }
    },
    spacing: {
        "0": "0",
        "5xs": "4px",
        "4xs": "6px",
        "3xs": "12px",
        "2xs": "16px",
        "xs": "22px",
        "sm": "32px",
        "md": "44px",
        "lg": "56px",
        "xl": "72px",
        "2xl": "90px",
        "3xl": "110px",
        "4xl": "130px",
        "5xl": "150px"
    },
    fontSize: {
        "3xl": "120px",
        "2xl": "86px",
        "xl": "70px",
        "lg": "48px",
        "md": "38px",
        "sm": "18px",
        DEFAULT: "16px",
        "xs": "16px",
        "2xs": "14px",
        "3xs": "12px",
        "h1": "40px",
        "h2": "36px",
        "h3": "34px",
        "h4": "28px",
        "h5": "26px",
        "h6": "24px",
        "s1": "22px",
        "s2": "20px"
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
            DEFAULT: "16px",
            "tablet-v": "24px",
            "tablet-h": "32px"
        },
        screens: {
            "tablet-v": "768px",
            "tablet-h": "992px",
            "laptop-sm": "1232px",
            "laptop-lg": "1200px"
        }
    }
  },
  plugins: [
    plugin(function({addBase, addComponents, addUtilities, theme}) {
        addBase({
            body: {
                backgroundColor: theme('colors.ivory.lightest'),
                color: theme('colors.thunder.darkest'),
                fontFamily: theme('fontFamily.roboto'),
                fontSize: theme('fontSize.DEFAULT'),
                fontWeight: 300
            },
            h1: {
                fontFamily: theme('fontFamily.roboto-flex'),
                fontSize: theme('fontSize.h1'),
                fontWeight: 400,
                lineHeight: "46px"
            },
            h2: {
                fontFamily: theme('fontFamily.roboto-flex'),
                fontSize: theme('fontSize.h2'),
                fontWeight: 400,
                lineHeight: "40px"
            },
            h3: {
                fontFamily: theme('fontFamily.roboto-flex'),
                fontSize: theme('fontSize.h3'),
                fontWeight: 400,
                lineHeight: "38px"
            },
            h4: {
                fontFamily: theme('fontFamily.roboto-flex'),
                fontSize: theme('fontSize.h4'),
                fontWeight: 400,
                lineHeight: "32px"
            },
            h5: {
                fontFamily: theme('fontFamily.roboto-flex'),
                fontSize: theme('fontSize.h5'),
                fontWeight: 400,
                lineHeight: "30px"
            },
            h6: {
                fontFamily: theme('fontFamily.roboto-flex'),
                fontSize: theme('fontSize.h6'),
                fontWeight: 400,
                lineHeight: "26px"
            },
            ".subtitle-1": {
                fontFamily: theme('fontFamily.roboto'),
                fontSize: theme('fontSize.s1'),
                fontWeight: 400,
                lineHeight: "1.5rem"
            },
            ".subtitle-2": {
                fontFamily: theme('fontFamily.roboto'),
                fontSize: theme('fontSize.s2'),
                fontWeight: 400,
                lineHeight: "1.375rem"
            },
            ".text-huge": {
                fontFamily: theme('fontFamily.oswald'),
                fontSize: theme('fontSize.3xl'),
                fontWeight: 400
            },
            ".text-biggest": {
                fontFamily: theme('fontFamily.oswald'),
                fontSize: theme('fontSize.2xl'),
                fontWeight: 400
            },
            ".text-bigger": {
                fontFamily: theme('fontFamily.oswald'),
                fontSize: theme('fontSize.xl'),
                fontWeight: 400
            },
            ".text-big": {
                fontFamily: theme('fontFamily.oswald'),
                fontSize: theme('fontSize.lg'),
                fontWeight: 400
            },
            ".text-medium": {
                fontFamily: theme('fontFamily.oswald'),
                fontSize: theme('fontSize.md'),
                fontWeight: 400
            },
            a: {
                color: theme('colors.stiletto.DEFAULT'),
                textDecoration: 'underline'
            }
        })

        addComponents({
            ".prose": {
                fontSize: theme('fontSize.sm'),
                "h1, h2, h3, h4, h5, h6": {
                    marginTop: theme('spacing.xs'),
                    marginBottom: theme('spacing.3xs'),
                    "&:first-child": {
                        marginTop: 0
                    },
                    "&:last-child": {
                        marginBottom: 0
                    }
                },
                figure: {
                    marginTop: theme('spacing.2xs'),
                    marginBottom: theme('spacing.2xs'),
                    textAlign: 'center',
                    "&:first-child": {
                        marginTop: 0
                    },
                    "&:last-child": {
                        marginBottom: 0
                    },
                    img: {
                        display: 'inline'
                    },
                    figcaption: {
                        fontStyle: 'italic'
                    }
                },
                p: {
                    marginTop: theme('spacing.3xs'),
                    marginBottom: theme('spacing.3xs'),
                    "&:first-child": {
                        marginTop: 0
                    },
                    "&:last-child": {
                        marginBottom: 0
                    }
                },
                ul: {
                    marginTop: theme('spacing.3xs'),
                    marginBottom: theme('spacing.3xs'),
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

        addUtilities({
            '.writing-h-tb': {
                'writing-mode': 'horizontal-tb'
            },
            '.writing-v-lr': {
                'writing-mode': 'vertical-lr'
            },
            '.writing-v-rl': {
                'writing-mode': 'vertical-rl'
            },
            '.scrollbar-hide': {
                'scrollbar-width': 'none',
                '-ms-overflow-style': 'none',
                '&::-webkit-scrollbar': {
                    'display': 'none'
                }
            }
        })
    })
  ],
}
