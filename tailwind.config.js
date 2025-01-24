import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */

const colors = ['yellow', 'violet', 'green','blue','red','gray','white','pink'];

const safelist = [
    ...colors.flatMap(color => [
        `hover:text-${color}-600`,
        `hover:bg-${color}-200`,
        `hover:outline-${color}-600`,
        `hover:outline-${color}-500`,
        `bg-${color}-50`,
        `hover:bg-${color}-700`,
        `text-${color}-50`,
        `bg-${color}-700`,
        `bg-${color}-400`,
        `bg-${color}-600`,
        `bg-${color}-200`,
        `bg-${color}-100`,
        `hover:bg-${color}-600`,
        `text-${color}`,
        `text-${color}-700`,
        `hover:text-${color}-50`,
        'flex-col',
        'flex-row',
    ]),

];

export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    safelist,

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            width: {

                'screen': '110rem',
                'screen2': '56rem',
                'screen3': '95rem',
                'screen4': '200rem',

              },

              spacing: {
                '1/3': '10%',
              },
              translate: {
                'first': '36rem',
              }

        },

    },

    plugins: [],

};

