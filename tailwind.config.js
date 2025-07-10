import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/views/**/**/*.blade.php",
    ],
    safelist: [//tailwind css色が反映されない件の対策(topPage)
        {
            pattern: /bg-(red|yellow|green|blue|sky|teal|cyan)-100/,
        },
        {
            pattern: /text-(red|yellow|green|blue|sky|teal|cyan)-800/,
        },
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
