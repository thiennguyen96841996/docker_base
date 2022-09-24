import * as path from "path";
import type { Configuration } from 'webpack';
import CopyPlugin from "copy-webpack-plugin";

const MODE = "development";

const config: Configuration = {
    mode: MODE,
    devtool: "eval-source-map",
    entry: {
        customer: path.resolve(__dirname, 'resources/customer/js/app.tsx'),
        client: path.resolve(__dirname, 'resources/client/js/app.tsx'),
        admin: path.resolve(__dirname, 'resources/admin/js/app.tsx'),
    },
    output: {
        path: path.resolve(__dirname, 'public/'),
        filename: (pathData: any) => {
            if (pathData.chunk.name === 'vendor') {
                return 'customer/dist/js/' + pathData.chunk.name +'.bundle.js'
            }
            return pathData.chunk.name + '/dist/js/app.bundle.js'
        },
    },
    module: {
        rules: [
            {
                test: /\.(ts|tsx)$/,
                use: { loader: "ts-loader" },
                exclude: /node_modules/,
            },
            {
                test: /\.(css|scss|sass)/,
                use: [
                    { loader: "style-loader" },
                    { loader: "css-loader" },
                    { loader: "sass-loader" },
                ]
            },
        ]
    },
    optimization: {
        splitChunks: {
            cacheGroups: {
                vendor: {// 依存ライブラリをまとめる
                    test: /node_modules/,
                    name: 'vendor',
                    chunks: 'initial',
                    enforce: true
                },
            }
        }
    },
    plugins: [
        new CopyPlugin({
            patterns: [
                {
                    from: path.resolve(__dirname, 'public/customer/dist/js/vendor.bundle.js'),
                    to: path.resolve(__dirname, 'public/client/dist/js/vendor.bundle.js')
                },
                {
                    from: path.resolve(__dirname, 'public/customer/dist/js/vendor.bundle.js'),
                    to: path.resolve(__dirname, 'public/admin/dist/js/vendor.bundle.js')
                },
            ]
        })
    ],
    resolve: {
        extensions: [ '.ts', '.js', '.tsx', '.jsx' ],
        alias: {
            '@customer': path.resolve(__dirname, 'resources/customer/'),
            '@client': path.resolve(__dirname, 'resources/client/'),
            '@admin': path.resolve(__dirname, 'resources/admin/'),
        }
    },
    watchOptions: {
        ignored: /node_modules/
    },
};
export default config
