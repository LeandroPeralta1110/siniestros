// vite.config.js
import { defineConfig } from "file:///C:/xampp/htdocs/siniestros/node_modules/vite/dist/node/index.js";
import laravel, { refreshPaths } from "file:///C:/xampp/htdocs/siniestros/node_modules/laravel-vite-plugin/dist/index.js";
var vite_config_default = defineConfig({
  server: {
    // Cambia la dirección a la dirección IP de tu servidor y el puerto de Vite
    host: "192.168.0.118",
    // Cambia a la dirección IP de tu servidor
    port: 5174
    // Cambia al puerto que estás utilizando
  },
  plugins: [
    laravel({
      input: [
        "resources/css/app.css",
        "resources/js/app.js"
      ],
      refresh: [
        ...refreshPaths,
        "app/Http/Livewire/**"
      ]
    })
  ]
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFx4YW1wcFxcXFxodGRvY3NcXFxcc2luaWVzdHJvc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9maWxlbmFtZSA9IFwiQzpcXFxceGFtcHBcXFxcaHRkb2NzXFxcXHNpbmllc3Ryb3NcXFxcdml0ZS5jb25maWcuanNcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfaW1wb3J0X21ldGFfdXJsID0gXCJmaWxlOi8vL0M6L3hhbXBwL2h0ZG9jcy9zaW5pZXN0cm9zL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCwgeyByZWZyZXNoUGF0aHMgfSBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcblxuZXhwb3J0IGRlZmF1bHQgZGVmaW5lQ29uZmlnKHtcbiAgICBzZXJ2ZXI6IHtcbiAgICAgICAgLy8gQ2FtYmlhIGxhIGRpcmVjY2lcdTAwRjNuIGEgbGEgZGlyZWNjaVx1MDBGM24gSVAgZGUgdHUgc2Vydmlkb3IgeSBlbCBwdWVydG8gZGUgVml0ZVxuICAgICAgICBob3N0OiAnMTkyLjE2OC4wLjExOCcsIC8vIENhbWJpYSBhIGxhIGRpcmVjY2lcdTAwRjNuIElQIGRlIHR1IHNlcnZpZG9yXG4gICAgICAgIHBvcnQ6IDUxNzQsIC8vIENhbWJpYSBhbCBwdWVydG8gcXVlIGVzdFx1MDBFMXMgdXRpbGl6YW5kb1xuICAgIH0sXG4gICAgcGx1Z2luczogW1xuICAgICAgICBsYXJhdmVsKHtcbiAgICAgICAgICAgIGlucHV0OiBbXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9jc3MvYXBwLmNzcycsXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9qcy9hcHAuanMnLFxuICAgICAgICAgICAgXSxcbiAgICAgICAgICAgIHJlZnJlc2g6IFtcbiAgICAgICAgICAgICAgICAuLi5yZWZyZXNoUGF0aHMsXG4gICAgICAgICAgICAgICAgJ2FwcC9IdHRwL0xpdmV3aXJlLyoqJyxcbiAgICAgICAgICAgIF0sXG4gICAgICAgIH0pLFxuICAgIF0sXG59KTtcbiJdLAogICJtYXBwaW5ncyI6ICI7QUFBd1EsU0FBUyxvQkFBb0I7QUFDclMsT0FBTyxXQUFXLG9CQUFvQjtBQUV0QyxJQUFPLHNCQUFRLGFBQWE7QUFBQSxFQUN4QixRQUFRO0FBQUE7QUFBQSxJQUVKLE1BQU07QUFBQTtBQUFBLElBQ04sTUFBTTtBQUFBO0FBQUEsRUFDVjtBQUFBLEVBQ0EsU0FBUztBQUFBLElBQ0wsUUFBUTtBQUFBLE1BQ0osT0FBTztBQUFBLFFBQ0g7QUFBQSxRQUNBO0FBQUEsTUFDSjtBQUFBLE1BQ0EsU0FBUztBQUFBLFFBQ0wsR0FBRztBQUFBLFFBQ0g7QUFBQSxNQUNKO0FBQUEsSUFDSixDQUFDO0FBQUEsRUFDTDtBQUNKLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
