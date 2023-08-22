export default {
  functional: true,
  props: {
    row: Object,
    render: Function
  },
  render(h, ctx) {
    const params = {
      row: ctx.props.row
    }

    return ctx.props.render(h, params)
  }
}
