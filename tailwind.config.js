module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],

    fontFamily: {
        // sans: ['Graphik', 'sans-serif'],
        // serif: ['Merriweather', 'serif'],
    },
    theme: {
        extend: {
            spacing: {
                60: "60px",
            },
            colors: {
                background: "#ECF6FD",
                violet: {
                    1: "#EFEDFC",
                    2: "#C2B9F3",
                    3: "#9585E8",
                    4: "#4C32DA",
                    5: "#2A1B77",
                },
                blue: {
                    1: "#CCCBF6",
                    2: "#8787E7",
                    3: "#5757DD",
                    4: "#202088",
                    5: "#181956",
                },
                sky: {
                    1: "#ECF6FD",
                    2: "#A3CCF3",
                    3: "#2C84E1",
                    4: "#1F66B2",
                    5: "#2A1B77",
                },
                black: {
                    1: "#E9E9EB",
                    2: "#C0C0C2",
                    3: "#96959A",
                    4: "#48474B",
                    5: "#2C2C2E",
                },
                green: {
                    1: "#D8EAD4",
                    2: "#B4D8AC",
                    3: "#83BC73",
                    4: "#5A984A",
                    5: "#35542C",
                },
                primary: {
                    1: {
                        1: "#7059E2",
                    },
                    3: {
                        1: "#569FE8",
                    },
                },
                white: "#FFFFFF",
                base: "#5D5D60",
                error: '#FF0000',
                placeholder: "#96959A",
            },
            fontSize: {
                12: [
                    "12px",
                    {
                        lineHeight: "11px",
                    },
                ],
                16: [
                    "16px",
                    {
                        lineHeight: "15px",
                    },
                ],
                18: [
                    "18px",
                    {
                        lineHeight: "17px",
                    },
                ],
                20: [
                    "20px",
                    {
                        lineHeight: "19px",
                    },
                ],
                24: [
                    "24px",
                    {
                        lineHeight: "23px"
                    }
                ]
            },
            fontFamily: {
                montserrat: ['Montserrat', 'sans-serif']

            },
            borderRadius: {
                35: "35px",
                56: "56px",
                45: "45px",
            },
            maxHeight: {
                // "10v": "10vh",
                // "20v": "20vh",
                // "30v": "30vh",
                // "40v": "40vh",
                // "50v": "50vh",
                // "60v": "60vh",
                // "70v": "70vh",
                // "80v": "80vh",
                // "90v": "90vh",
                // "100v": "100vh",
            },

            boxShadow: {
                form: "0px 4px 4px rgba(222, 236, 250, 0.5)",
            },
        },
    },
    plugins: [],
};
