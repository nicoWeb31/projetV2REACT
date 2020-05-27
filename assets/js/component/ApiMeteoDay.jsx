import React, { Component,Fragment} from "react";


class ApiMeteoDay extends Component {
  constructor(props) {
    super(props);
    this.state = {  };
  }
  render() {
    return (


      <div>
      <img src={this.props.data && `http://openweathermap.org/img/wn/${this.props.data.weather[0].icon}@2x.png`} class="card-img-top" alt="..."/>



        <p class="card-text">{this.props.data && this.props.data.weather[0].description}</p>

    </div>
    );
  }
}

export default ApiMeteoDay;
