let mix = require("laravel-mix");
let path = require("path");

require("./mix");

mix.setPublicPath("dist")
    .js("resources/js/field.js", "js")
    .vue({ version: 3 })
    .webpackConfig({
        externals: {
            vue: "Vue",
        },
        output: {
            uniqueName: "vendor/package",
        },
    })
    .sass("resources/sass/field.sass", "css");

const CKEditorWebpackPlugin = require("@ckeditor/ckeditor5-dev-webpack-plugin");
const CKEditorStyles = require("@ckeditor/ckeditor5-dev-utils").styles;
//Includes SVGs and CSS files from "node_modules/ckeditor5-*" and any other custom directories
const CKEditorRegex = {
    svg: /ckeditor5-[^/\\]+[/\\]theme[/\\]icons[/\\][^/\\]+\.svg$/, //If you have any custom plugins in your project with SVG icons, include their path in this regex as well.
    css: /ckeditor5-[^/\\]+[/\\].+\.css$/,
};

//Exclude CKEditor regex from mix's default rules
Mix.listen("configReady", (config) => {
    const rules = config.module.rules;
    const targetSVG =
        /(\.(png|jpe?g|gif|webp|avif)$|^((?!font).)*\.svg$)/.toString();
    const targetFont = /(\.(woff2?|ttf|eot|otf)$|font.*\.svg$)/.toString();
    const targetCSS = /\.p?css$/.toString();

    rules.forEach((rule) => {
        let test = rule.test.toString();
        if ([targetSVG, targetFont].includes(rule.test.toString())) {
            rule.exclude = CKEditorRegex.svg;
        } else if (test === targetCSS) {
            rule.exclude = CKEditorRegex.css;
        }
    });
});

mix.webpackConfig({
    plugins: [
        new CKEditorWebpackPlugin({
            language: "en",
            addMainLanguageTranslationsToAllAssets: true,
        }),
    ],
    module: {
        rules: [
            {
                test: CKEditorRegex.svg,
                use: ["raw-loader"],
            },
            {
                test: CKEditorRegex.css,
                use: [
                    {
                        loader: "style-loader",
                        options: {
                            injectType: "singletonStyleTag",
                            attributes: {
                                "data-cke": true,
                            },
                        },
                    },
                    "css-loader",
                    {
                        loader: "postcss-loader",
                        options: {
                            postcssOptions: CKEditorStyles.getPostCssConfig({
                                themeImporter: {
                                    themePath: require.resolve(
                                        "@ckeditor/ckeditor5-theme-lark"
                                    ),
                                },
                                minify: true,
                            }),
                        },
                    },
                ],
            },
        ],
    },
});
