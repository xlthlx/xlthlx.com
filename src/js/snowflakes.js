// See sources on GitHub:
// https://github.com/mkalygin/snowflakes

window.snowConfig = {
  density: 1 / 90,
  depth: 60,
  count: 150,
  gravity: 200,
  speed: 1 / 20000,
  color: [0, 0, 0],
  opacity: 0.6,
  snowflake: 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSI2NCIgaGVpZ2h0PSI2NCIgZmlsbD0iI2ZmZiIgdmlld0JveD0iMCAwIDUxMiA1MTIiPgogIDxwYXRoIGZpbGw9IiNjZmQyY2YiIGQ9Im0zMTcuNzE1IDE1MC4wNjktNi45MDMgNzMuOTEzTDM3OS41MDggMjU2bC02OC40MTQgMzEuNTMyIDYuNjIxIDc0LjM5OS02MS43OTMtNDQuMTM4LTYxLjc5MyA0NC4xMzggNy4zODgtNzIuODI4TDEzMi4yMjEgMjU2bDY4LjUyOC0zMS41MzItNi42Mi03NC4zOTkgNjEuNzkzIDQ0LjEzOHoiLz4KICA8ZyBmaWxsPSIjZTRlNWU2Ij4KICAgIDxwYXRoIGQ9Ik0yODIuNDA1IDI1NmMwLTE0LjYyNy0xMS44NTUtMjYuNDgzLTI2LjQ4My0yNi40ODMtMTQuNjI3IDAtMjYuNDgzIDExLjg1NS0yNi40ODMgMjYuNDgzIDAgMTQuNjI3IDExLjg1NSAyNi40ODMgMjYuNDgzIDI2LjQ4MyAxNC42MjcgMCAyNi40ODMtMTEuODU2IDI2LjQ4My0yNi40ODMiLz4KICAgIDxwYXRoIGQ9Ik0yNTUuOTIyIDIzOC4zNDVhOC44MiA4LjgyIDAgMCAxLTguODI4LTguODI4VjUyLjk2NmMwLTQuODgyIDMuOTQ2LTguODI4IDguODI4LTguODI4czguODI4IDMuOTQ2IDguODI4IDguODI4djE3Ni41NTJhOC44MiA4LjgyIDAgMCAxLTguODI4IDguODI3Ii8+CiAgICA8cGF0aCBkPSJNMjU1LjkyMiAxMTQuODcxYTguODA4IDguODA4IDAgMCAxLTYuMjMyLTIuNTc4bC0zNS4zMS0zNS4xOTZhOC44MjYgOC44MjYgMCAwIDEtLjAxOC0xMi40ODJjMy40NDMtMy40NiA5LjAyMi0zLjQ1MiAxMi40ODItLjAxOGwyOS4wNzggMjguOTgxTDI4NSA2NC41OThhOC44MDkgOC44MDkgMCAwIDEgMTIuNDgyLjAxOCA4LjgyNSA4LjgyNSAwIDAgMS0uMDE4IDEyLjQ4MmwtMzUuMzEgMzUuMTk2YTguODExIDguODExIDAgMCAxLTYuMjMyIDIuNTc3Ii8+CiAgICA8cGF0aCBkPSJNMjU1LjkyMiAxNTguODk3YTguODA4IDguODA4IDAgMCAxLTYuMjMyLTIuNTc4bC01Mi45NjYtNTIuODUxYy0zLjQ2LTMuNDUyLTMuNDYtOS4wMzktLjAxOC0xMi40ODIgMy40NTItMy40NjkgOS4wMzEtMy40NTIgMTIuNDgyLS4wMThsNDYuNzMzIDQ2LjYyNyA0Ni43MzMtNDYuNjI3YzMuNDUyLTMuNDM0IDkuMDMxLTMuNDUyIDEyLjQ4Mi4wMTggMy40NDMgMy40NDMgMy40NDMgOS4wMzEtLjAxOCAxMi40ODJsLTUyLjk2NiA1Mi44NTFhOC44MDQgOC44MDQgMCAwIDEtNi4yMyAyLjU3OCIvPgogIDwvZz4KICA8cGF0aCBmaWxsPSIjY2ZkMmNmIiBkPSJNMjgyLjQwNSAyNi40ODNDMjgyLjQwNSAxMS44NTUgMjcwLjU0OSAwIDI1NS45MjIgMHMtMjYuNDgzIDExLjg1NS0yNi40ODMgMjYuNDgzIDExLjg1NSAyNi40ODMgMjYuNDgzIDI2LjQ4M2MxNC42MjcgMCAyNi40ODMtMTEuODU2IDI2LjQ4My0yNi40ODMiLz4KICA8ZyBmaWxsPSIjZTRlNWU2Ij4KICAgIDxwYXRoIGQ9Ik0yNTUuOTIyIDQ2Ny44NjJhOC44MiA4LjgyIDAgMCAxLTguODI4LTguODI4VjI4Mi40ODNjMC00Ljg4MiAzLjk0Ni04LjgyOCA4LjgyOC04LjgyOHM4LjgyOCAzLjk0NiA4LjgyOCA4LjgyOHYxNzYuNTUyYTguODIgOC44MiAwIDAgMS04LjgyOCA4LjgyNyIvPgogICAgPHBhdGggZD0iTTI5MS4yMzIgNDQ5Ljk4M2E4LjgwOCA4LjgwOCAwIDAgMS02LjIzMi0yLjU3OGwtMjkuMDc4LTI4Ljk4MS0yOS4wNzggMjguOTgxYy0zLjQ2OSAzLjQ0My05LjA0OCAzLjQzNC0xMi40ODItLjAxOGE4LjgyNSA4LjgyNSAwIDAgMSAuMDE4LTEyLjQ4MmwzNS4zMS0zNS4xOTZhOC44MjkgOC44MjkgMCAwIDEgMTIuNDY1IDBsMzUuMzEgMzUuMTk2YzMuNDUyIDMuNDQzIDMuNDYgOS4wMjIuMDE4IDEyLjQ4MmE4Ljc4MSA4Ljc4MSAwIDAgMS02LjI1MSAyLjU5NiIvPgogICAgPHBhdGggZD0iTTMwOC44ODcgNDIzLjYxMmE4LjgwOCA4LjgwOCAwIDAgMS02LjIzMi0yLjU3OGwtNDYuNzMzLTQ2LjYyNy00Ni43MzMgNDYuNjI3Yy0zLjQ1MiAzLjQzNC05LjAzMSAzLjQ1Mi0xMi40ODItLjAxOGE4LjgxNyA4LjgxNyAwIDAgMSAuMDE4LTEyLjQ4Mmw1Mi45NjYtNTIuODUxYTguODI5IDguODI5IDAgMCAxIDEyLjQ2NSAwbDUyLjk2NiA1Mi44NTFhOC44MTkgOC44MTkgMCAwIDEgLjAxOCAxMi40ODIgOC44MDQgOC44MDQgMCAwIDEtNi4yNTMgMi41OTZtLTMwLjI5Mi0xNzIuNDkxYTguODA0IDguODA0IDAgMCAxLTcuNTU2LTQuMjU1Yy0yLjUzNC00LjE3NS0xLjE5Mi05LjYwNCAyLjk3NS0xMi4xMmwxNTguMTQ2LTk1LjYzOGM0LjE4NC0yLjU0MiA5LjU5Ni0xLjE4MyAxMi4xMiAyLjk3NSAyLjUyNSA0LjE3NSAxLjE4MyA5LjYwNC0yLjk4NCAxMi4xMmwtMTU4LjEzNyA5NS42MzhhOC44MyA4LjgzIDAgMCAxLTQuNTY0IDEuMjgiLz4KICAgIDxwYXRoIGQ9Ik00MzIuNjM4IDE5OS4yMjRhOS4yMDMgOS4yMDMgMCAwIDEtMi4xMjctLjI1NmwtNDguMzkzLTEyLjAwNmMtNC43MjMtMS4xNjUtNy42MDktNS45NDEtNi40NTMtMTAuNjY0bDExLjg0Ny00OC40MjhjMS4xNjUtNC43NDkgNS45ODUtNy42MzYgMTAuNjczLTYuNDc5IDQuNzQgMS4xNTYgNy42MzYgNS45MzIgNi40NzkgMTAuNjczbC05Ljc1NSAzOS44ODMgMzkuODM5IDkuODc4YzQuNzMyIDEuMTc0IDcuNjI3IDUuOTY3IDYuNDUzIDEwLjY5YTguODQzIDguODQzIDAgMCAxLTguNTYzIDYuNzA5Ii8+CiAgICA8cGF0aCBkPSJNNDE5LjIwNyAyMjcuOTc0YTkuMjYyIDkuMjYyIDAgMCAxLTIuMTI3LS4yNTZsLTcyLjYzMy0xNy45NjRhOC44MzQgOC44MzQgMCAwIDEtNi40NTMtMTAuNjczbDE3LjgwNS03Mi42NzhjMS4xNjUtNC43MzIgNS45NjctNy42MTggMTAuNjgxLTYuNDcxIDQuNzMyIDEuMTY1IDcuNjM2IDUuOTQxIDYuNDc5IDEwLjY4MWwtMTUuNzIyIDY0LjEwNiA2NC4wNzkgMTUuODU0YzQuNzMyIDEuMTc0IDcuNjI3IDUuOTU5IDYuNDUzIDEwLjY5YTguODM3IDguODM3IDAgMCAxLTguNTYyIDYuNzExIi8+CiAgPC9nPgogIDxwYXRoIGZpbGw9IiNjZmQyY2YiIGQ9Ik00ODUuNTk1IDEzMi41MjVjMC0xNC42MjctMTEuODU1LTI2LjQ4My0yNi40ODMtMjYuNDgzcy0yNi40ODMgMTEuODU1LTI2LjQ4MyAyNi40ODMgMTEuODU1IDI2LjQ4MyAyNi40ODMgMjYuNDgzIDI2LjQ4My0xMS44NTYgMjYuNDgzLTI2LjQ4MyIvPgogIDxnIGZpbGw9IiNlNGU1ZTYiPgogICAgPHBhdGggZD0iTTIzMi44MTggMjUxLjg2M2E4LjczNSA4LjczNSAwIDAgMS00LjMwOC0xLjEzTDcxLjMyNiAxNjIuNDc0Yy00LjI0Ni0yLjM4My01Ljc2NC03Ljc2OC0zLjM4MS0xMi4wMTQgMi4zODMtNC4yNjQgNy43NzctNS43NzMgMTIuMDIzLTMuMzgxbDE1Ny4xNzUgODguMjU4YzQuMjU1IDIuMzgzIDUuNzczIDcuNzY4IDMuMzgxIDEyLjAxNGE4LjgyNyA4LjgyNyAwIDAgMS03LjcwNiA0LjUxMiIvPgogICAgPHBhdGggZD0iTTc3LjE4MSAyMDQuOTY2YTguODEyIDguODEyIDAgMCAxLTguNDgzLTYuNDM1IDguODEzIDguODEzIDAgMCAxIDYuMDkxLTEwLjg4NGwzOS41MDMtMTEuMTY3LTExLjAzNC0zOS41NDhjLTEuMzA2LTQuNjg3IDEuNDMtOS41NiA2LjEyNi0xMC44NjcgNC42NzktMS4zMDYgOS41NiAxLjQyMSAxMC44NzYgNi4xMjZsMTMuNCA0OC4wMjJjMS4zMTUgNC42ODctMS40MjEgOS41NDMtNi4xIDEwLjg2N2wtNDcuOTc4IDEzLjU1YTguNTk3IDguNTk3IDAgMCAxLTIuNDAxLjMzNiIvPgogICAgPHBhdGggZD0iTTkxLjUyNiAyMzMuMjc2YTguODMyIDguODMyIDAgMCAxLTguNDkyLTYuNDM1Yy0xLjMxNS00LjY4NyAxLjQxMi05LjU2IDYuMS0xMC44OTNsNjMuNTUtMTcuOTExLTE3Ljc4OC02My41NzZjLTEuMzA2LTQuNzA1IDEuNDMtOS41NjkgNi4xMTgtMTAuODg0IDQuNjYxLTEuMjk4IDkuNTc4IDEuNDIxIDEwLjg4NCA2LjEyNmwyMC4xNTMgNzIuMDZjMS4zMTUgNC42ODctMS40MjEgOS41NTEtNi4xIDEwLjg3NmwtNzIuMDI0IDIwLjMxMmE5LjA2MiA5LjA2MiAwIDAgMS0yLjQwMS4zMjUiLz4KICA8L2c+CiAgPHBhdGggZmlsbD0iI2NmZDJjZiIgZD0iTTUzLjg2IDExNC43NzZjLTE0LjYxOC0uNTM4LTI2Ljg5OCAxMC44NzYtMjcuNDM2IDI1LjQ5NC0uNTM4IDE0LjYxIDEwLjg3NiAyNi44OTggMjUuNDk0IDI3LjQzNiAxNC42MS41MzggMjYuODk4LTEwLjg3NiAyNy40MzYtMjUuNDk0LjUzOS0xNC42MTgtMTAuODc1LTI2Ljg5Ny0yNS40OTQtMjcuNDM2Ii8+CiAgPGcgZmlsbD0iI2U0ZTVlNiI+CiAgICA8cGF0aCBkPSJNNzUuMjg0IDM3NC4yODRhOC44MDQgOC44MDQgMCAwIDEtNy41NTYtNC4yNTVjLTIuNTM0LTQuMTc1LTEuMTkyLTkuNjA0IDIuOTc1LTEyLjEybDE1OC4xNDYtOTUuNjM4YzQuMTc1LTIuNTQyIDkuNTg3LTEuMTgzIDEyLjEyIDIuOTc1IDIuNTI1IDQuMTc1IDEuMTgzIDkuNjA0LTIuOTg0IDEyLjEyTDc5Ljg0OCAzNzMuMDA0YTguODI4IDguODI4IDAgMCAxLTQuNTY0IDEuMjgiLz4KICAgIDxwYXRoIGQ9Ik0xMTUuOTIyIDM5MC45NzRhOC45NzEgOC45NzEgMCAwIDEtMi4xMDEtLjI0N2MtNC43NC0xLjE2NS03LjY0NS01Ljk0MS02LjQ4OC0xMC42NzNsOS43NzItMzkuODkyLTM5Ljg1Ny05Ljg3OGMtNC43MzItMS4xNzQtNy42MTgtNS45NjctNi40NDQtMTAuNjkgMS4xNjUtNC43NCA1Ljk5NC03LjYwMSAxMC42OS02LjQ0NGw0OC4zOTMgMTEuOTk3YzQuNzIzIDEuMTc0IDcuNjA5IDUuOTQxIDYuNDUzIDEwLjY2NGwtMTEuODQ3IDQ4LjQyOGE4Ljg0NCA4Ljg0NCAwIDAgMS04LjU3MSA2LjczNSIvPgogICAgPHBhdGggZD0iTTE0Ny42MjkgMzkyLjQzMWE5LjEwMyA5LjEwMyAwIDAgMS0yLjExLS4yNDdjLTQuNzMyLTEuMTY1LTcuNjM2LTUuOTUtNi40NzktMTAuNjgxbDE1LjczMS02NC4xMTUtNjQuMDg4LTE1Ljg1NGE4LjgzOCA4LjgzOCAwIDAgMS02LjQ1My0xMC42OWMxLjE2NS00LjczMiA1Ljk0MS03LjYwMSAxMC42OS02LjQ0NGw3Mi42NDIgMTcuOTY0YTguODM0IDguODM0IDAgMCAxIDYuNDUzIDEwLjY3M0wxNTYuMiAzODUuNzA1YTguODU0IDguODU0IDAgMCAxLTguNTcxIDYuNzI2Ii8+CiAgPC9nPgogIDxwYXRoIGZpbGw9IiNjZmQyY2YiIGQ9Ik0yNi40MDUgMzc5LjU4NmMwIDE0LjYyNyAxMS44NTUgMjYuNDgzIDI2LjQ4MyAyNi40ODNzMjYuNDgzLTExLjg1NSAyNi40ODMtMjYuNDgzLTExLjg1NS0yNi40ODMtMjYuNDgzLTI2LjQ4My0yNi40ODMgMTEuODU2LTI2LjQ4MyAyNi40ODMiLz4KICA8ZyBmaWxsPSIjZTRlNWU2Ij4KICAgIDxwYXRoIGQ9Ik00MzYuMzQ0IDM2Ni4xNTVhOC43MzUgOC43MzUgMCAwIDEtNC4zMDgtMS4xM2wtMTU3LjE4NC04OC4yNDljLTQuMjQ2LTIuMzkyLTUuNzY0LTcuNzY4LTMuMzgxLTEyLjAxNCAyLjM5Mi00LjI2NCA3Ljc3Ny01Ljc3MyAxMi4wMjMtMy4zODFMNDQwLjY3IDM0OS42M2M0LjI1NSAyLjM4MyA1Ljc3MyA3Ljc2OCAzLjM4MSAxMi4wMTRhOC44MjkgOC44MjkgMCAwIDEtNy43MDcgNC41MTEiLz4KICAgIDxwYXRoIGQ9Ik00MDAuMjMzIDM4Ni4zNzljLTMuODU4IDAtNy40MDYtMi41NTEtOC40OTItNi40NTNsLTEzLjQtNDguMDMxYy0xLjMxNS00LjY3OSAxLjQyMS05LjU0MyA2LjEtMTAuODU4bDQ3Ljk3OC0xMy41NTljNC42MzQtMS4zMzMgOS41NiAxLjM4NiAxMC44ODQgNi4xIDEuMzI0IDQuNjg3LTEuMzk1IDkuNTY5LTYuMSAxMC44ODRsLTM5LjQ5NSAxMS4xNjcgMTEuMDM0IDM5LjU0OGE4LjgzMiA4LjgzMiAwIDAgMS04LjUwOSAxMS4yMDIiLz4KICAgIDxwYXRoIGQ9Ik0zNjguNTk1IDM4OC44NjJjLTMuODU4IDAtNy40MDYtMi41NTEtOC40OTItNi40NDRMMzM5Ljk1IDMxMC4zNWMtMS4zMTUtNC42ODcgMS40MjEtOS41NTEgNi4xLTEwLjg3Nmw3Mi4wMTUtMjAuMzEyYzQuNzE0LTEuMjk4IDkuNTY5IDEuNDIxIDEwLjkwMiA2LjEwOSAxLjMxNSA0LjY4Ny0xLjQxMiA5LjU2OS02LjEwOSAxMC44OTNsLTYzLjU0MSAxNy45MTEgMTcuNzg4IDYzLjU3NmMxLjMwNyA0LjcwNS0xLjQzIDkuNTY5LTYuMTE4IDEwLjg4NGE4LjkxOSA4LjkxOSAwIDAgMS0yLjM5Mi4zMjciLz4KICA8L2c+CiAgPHBhdGggZmlsbD0iI2NmZDJjZiIgZD0iTTQ1OC4xNCAzOTcuMzM1YzE0LjYxOC41MzggMjYuODk4LTEwLjg3NiAyNy40MzYtMjUuNDk0LjUzOC0xNC42MTgtMTAuODc2LTI2Ljg5OC0yNS40OTQtMjcuNDM2LTE0LjYxLS41MzgtMjYuODk4IDEwLjg3Ni0yNy40MzYgMjUuNDk0LS41MzkgMTQuNjE4IDEwLjg3NSAyNi44OTcgMjUuNDk0IDI3LjQzNm0tMTc1LjczNSA4OC4xODJjMC0xNC42MjctMTEuODU1LTI2LjQ4My0yNi40ODMtMjYuNDgzLTE0LjYyNyAwLTI2LjQ4MyAxMS44NTUtMjYuNDgzIDI2LjQ4M1MyNDEuMjk1IDUxMiAyNTUuOTIyIDUxMnMyNi40ODMtMTEuODU1IDI2LjQ4My0yNi40ODMiLz4KPC9zdmc+',
}

if (document.body.classList.contains('dark-theme') || 'dark' === localStorage.getItem('theme')) {
  window.snowConfig.opacity = 0.8
  window.snowConfig.color = [1, 1, 1]
}

class SnowProgram {
  constructor ($container, config) {
    const { density, depth, count, gravity, speed, color, opacity, snowflake } =
    config || {}

    this.density = density || 1 / 90
    this.depth = depth || 80
    this.count = count || 7000
    this.gravity = gravity || 100
    this.speed = speed || 1 / 5000
    this.color = window.snowConfig.color
    this.opacity = window.snowConfig.opacity
    this.snowflake =
      snowflake ||
      'data:image/png;base64,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'

    this.VERTEX_SOURCE = `
      precision highp float;

      attribute vec4 a_position;
      attribute vec4 a_color;
      attribute vec3 a_rotation;
      attribute vec3 a_speed;
      attribute float a_size;

      uniform float u_time;
      uniform mat4 u_projection;
      uniform vec3 u_worldSize;
      uniform float u_gravity;
      uniform float u_wind;

      varying vec4 v_color;
      varying float v_rotation;

      void main() {
        v_color = a_color;
        v_rotation = a_rotation.x + u_time * a_rotation.y;

        vec3 pos = a_position.xyz;

        pos.x = mod(pos.x + u_time + u_wind * a_speed.x, u_worldSize.x * 2.0) - u_worldSize.x;
        pos.y = mod(pos.y - u_time * a_speed.y * u_gravity, u_worldSize.y * 2.0) - u_worldSize.y;

        pos.x += sin(u_time * a_speed.z) * a_rotation.z;
        pos.z += cos(u_time * a_speed.z) * a_rotation.z;

        gl_Position = u_projection * vec4(pos.xyz, a_position.w);
        gl_PointSize = (a_size / gl_Position.w) * 100.0;
      }
    `

    this.FRAGMENT_SOURCE = `
      precision highp float;

      uniform sampler2D u_texture;

      varying vec4 v_color;
      varying float v_rotation;

      void main() {
        vec2 rotated = vec2(
          cos(v_rotation) * (gl_PointCoord.x - 0.5) + sin(v_rotation) * (gl_PointCoord.y - 0.5) + 0.5,
          cos(v_rotation) * (gl_PointCoord.y - 0.5) - sin(v_rotation) * (gl_PointCoord.x - 0.5) + 0.5
        );

        vec4 snowflake = texture2D(u_texture, rotated);

        gl_FragColor = vec4(snowflake.rgb * v_color.xyz, snowflake.a * v_color.a);
      }
    `

    this.INITIAL_BUFFERS = () => ({
      position: { size: 3, value: [] },
      color: { size: 4, value: [] },
      size: { size: 1, value: [] },
      rotation: { size: 3, value: [] },
      speed: { size: 3, value: [] },
    })

    this.INITIAL_UNIFORMS = () => ({
      time: { type: 'float', value: 0 },
      worldSize: { type: 'vec3', value: [0, 0, 0] },
      gravity: { type: 'float', value: this.gravity },
      wind: { type: 'float', value: 0 },
      projection: {
        type: 'mat4',
        value: [1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1],
      },
    })

    this.UNIFORM_SETTERS = {
      int: 'uniform1i',
      float: 'uniform1f',
      vec2: 'uniform2fv',
      vec3: 'uniform3fv',
      vec4: 'uniform4fv',
      mat2: 'uniformMatrix2fv',
      mat3: 'uniformMatrix3fv',
      mat4: 'uniformMatrix4fv',
    }

    this.CANVAS_STYLE = {
      position: 'fixed',
      top: 0,
      left: 0,
      width: '100vw',
      height: '100vh',
      background: 'transparent',
      'pointer-events': 'none',
    }

    this.CAMERA = {
      fov: 60,
      near: 1,
      far: 10000,
      aspect: 1,
      z: 100,
    }

    this.WIND = {
      current: 0,
      force: 0.1,
      target: 0.1,
      min: 0.1,
      max: 0.25,
      easing: 0.005,
    }

    this.init($container)
  }

  init ($container) {
    const $canvas = this.initCanvas()
    const gl = $canvas.getContext('webgl', { antialias: true })

    $container.append($canvas)

    this.$canvas = $canvas
    this.gl = gl
    this.program = this.initProgram()
    this.buffers = this.initBuffers()
    this.uniforms = this.initUniforms()
    this.texture = this.initTexture()
    this.camera = this.initCamera()
    this.wind = this.initWind()

    this.resize = this.resize.bind(this)
    this.update = this.update.bind(this)

    window.addEventListener('resize', this.resize)
  }

  initCanvas () {
    const $canvas = document.createElement('canvas')

    Object.assign($canvas.style, this.CANVAS_STYLE)

    return $canvas
  }

  initCamera () {
    return { ...this.CAMERA }
  }

  initWind () {
    return { ...this.WIND }
  }

  initShader (type, source) {
    const { gl } = this
    const shader = gl.createShader(type)

    gl.shaderSource(shader, source)
    gl.compileShader(shader)

    return shader
  }

  initProgram () {
    const { gl } = this
    const vertex = this.initShader(gl.VERTEX_SHADER, this.VERTEX_SOURCE)
    const fragment = this.initShader(gl.FRAGMENT_SHADER, this.FRAGMENT_SOURCE)
    const program = gl.createProgram()

    gl.attachShader(program, vertex)
    gl.attachShader(program, fragment)
    gl.linkProgram(program)
    gl.useProgram(program)

    return program
  }

  initBuffers () {
    const { gl, program } = this
    const buffers = this.INITIAL_BUFFERS()

    Object.entries(buffers).forEach(([name, buffer]) => {
      buffer.location = gl.getAttribLocation(program, `a_${name}`)
      buffer.ref = gl.createBuffer()

      gl.bindBuffer(gl.ARRAY_BUFFER, buffer.ref)
      gl.enableVertexAttribArray(buffer.location)
      gl.vertexAttribPointer(
        buffer.location,
        buffer.size,
        gl.FLOAT,
        false,
        0,
        0
      )
    })

    return buffers
  }

  updateBuffers () {
    const { gl, buffers } = this

    Object.keys(buffers).forEach((name) => {
      this.setBuffer(name)
    })
  }

  setBuffer (name, value) {
    const { gl, buffers } = this
    const buffer = buffers[name]

    buffer.value = new Float32Array(value || buffer.value)

    gl.bindBuffer(gl.ARRAY_BUFFER, buffer.ref)
    gl.bufferData(gl.ARRAY_BUFFER, buffer.value, gl.STATIC_DRAW)
  }

  initUniforms () {
    const { gl, program } = this
    const uniforms = this.INITIAL_UNIFORMS()

    Object.entries(uniforms).forEach(([name, uniform]) => {
      uniform.location = gl.getUniformLocation(program, `u_${name}`)
    })

    return uniforms
  }

  updateUniforms () {
    const { gl, uniforms } = this

    Object.keys(uniforms).forEach((name) => {
      this.setUniform(name)
    })
  }

  setUniform (name, value) {
    const { gl, uniforms } = this
    const uniform = uniforms[name]
    const setter = this.UNIFORM_SETTERS[uniform.type]
    const isMatrix = /^mat[2-4]$/i.test(uniform.type)

    uniform.value = value || uniform.value

    if (isMatrix) {
      gl[setter](uniform.location, false, uniform.value)
    } else {
      gl[setter](uniform.location, uniform.value)
    }
  }

  initTexture () {
    const { gl } = this
    const texture = gl.createTexture()
    const image = new Image()

    gl.bindTexture(gl.TEXTURE_2D, texture)
    gl.texImage2D(
      gl.TEXTURE_2D,
      0,
      gl.RGBA,
      1,
      1,
      0,
      gl.RGBA,
      gl.UNSIGNED_BYTE,
      new Uint8Array([0, 0, 0, 0])
    )

    image.onload = () => {
      gl.bindTexture(gl.TEXTURE_2D, texture)
      gl.texImage2D(
        gl.TEXTURE_2D,
        0,
        gl.RGBA,
        gl.RGBA,
        gl.UNSIGNED_BYTE,
        image
      )
      gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR)
      gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR)
      gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE)
      gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE)
    }

    image.src = this.snowflake

    return texture
  }

  initSnowflakes (vw, vh, dpi) {
    const position = []
    const color = []
    const size = []
    const rotation = []
    const speed = []

    const height = 1 / this.density
    const width = (vw / vh) * height
    const depth = this.depth
    const count = this.count
    const length = (vw / vh) * count

    for (let i = 0; i < length; ++i) {
      position.push(
        -width + Math.random() * width * 2,
        -height + Math.random() * height * 2,
        Math.random() * depth * 2
      )

      speed.push(1 + Math.random(), 1 + Math.random(), Math.random() * 10)

      rotation.push(
        Math.random() * 2 * Math.PI,
        Math.random() * 20,
        Math.random() * 10
      )

      color.push(...this.color, 0.1 + Math.random() * this.opacity)
      size.push((5 * Math.random() * 5 * vh * dpi) / 1000)
    }

    this.setUniform('worldSize', [width, height, depth])

    this.setBuffer('position', position)
    this.setBuffer('color', color)
    this.setBuffer('rotation', rotation)
    this.setBuffer('size', size)
    this.setBuffer('speed', speed)
  }

  setProjection (aspect) {
    const { camera } = this

    camera.aspect = aspect

    const fovRad = (camera.fov * Math.PI) / 180
    const f = Math.tan(Math.PI * 0.5 - 0.5 * fovRad)
    const rangeInv = 1.0 / (camera.near - camera.far)

    const m0 = f / camera.aspect
    const m5 = f
    const m10 = (camera.near + camera.far) * rangeInv
    const m11 = -1
    const m14 = camera.near * camera.far * rangeInv * 2 + camera.z
    const m15 = camera.z

    return [m0, 0, 0, 0, 0, m5, 0, 0, 0, 0, m10, m11, 0, 0, m14, m15]
  }

  render () {
    const { gl } = this

    gl.enable(gl.BLEND)
    gl.enable(gl.CULL_FACE)
    gl.blendFunc(gl.SRC_ALPHA, gl.ONE)
    gl.disable(gl.DEPTH_TEST)

    this.updateBuffers()
    this.updateUniforms()
    this.resize(true)

    this.time = {
      start: window.performance.now(),
      previous: window.performance.now(),
    }

    if (this.raf) window.cancelAnimationFrame(this.raf)
    this.raf = window.requestAnimationFrame(this.update)

    return this
  }

  resize (updateSnowflakes = false) {
    const { $canvas, gl } = this
    const vw = $canvas.offsetWidth
    const vh = $canvas.offsetHeight
    const aspect = vw / vh
    const dpi = window.devicePixelRatio

    $canvas.width = vw * dpi
    $canvas.height = vh * dpi

    gl.viewport(0, 0, vw * dpi, vh * dpi)
    gl.clearColor(0, 0, 0, 0)

    if (updateSnowflakes === true) {
      this.initSnowflakes(vw, vh, dpi)
    }

    this.setUniform('projection', this.setProjection(aspect))
  }

  update (timestamp) {
    const { gl, buffers, wind } = this
    const elapsed = (timestamp - this.time.start) * this.speed
    const delta = timestamp - this.time.previous

    gl.clear(gl.COLOR_BUFFER_BIT)
    gl.drawArrays(
      gl.POINTS,
      0,
      buffers.position.value.length / buffers.position.size
    )

    if (Math.random() > 0.995) {
      wind.target =
        (wind.min + Math.random() * (wind.max - wind.min)) *
        (Math.random() > 0.5 ? -1 : 1)
    }

    wind.force += (wind.target - wind.force) * wind.easing
    wind.current += wind.force * (delta * 0.2)

    this.setUniform('wind', wind.current)
    this.setUniform('time', elapsed)

    this.time.previous = timestamp

    this.raf = window.requestAnimationFrame(this.update)
  }
}

document.addEventListener('DOMContentLoaded', () => {
  window.snow = new SnowProgram(document.body, window.snowConfig).render()
})

const clickButton = document.querySelector('#btn-toggle')
clickButton.addEventListener('click', (e) => {
  e.preventDefault()
  window.snowConfig.opacity = 0.6
  window.snowConfig.color = [0, 0, 0]

  if (document.body.classList.contains('dark-theme') || 'dark' === localStorage.getItem('theme')) {
    window.snowConfig.opacity = 0.8
    window.snowConfig.color = [1, 1, 1]
  }

  delete window.snow
  window.snow = new SnowProgram(document.body, window.snowConfig).render()
})