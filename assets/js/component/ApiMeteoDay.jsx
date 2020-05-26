import React, { Component } from "react";


class ApiMeteoDay extends Component {
  constructor(props) {
    super(props);
    this.state = {};
  }

 

  render() {

    console.log(this.props.data)


    return (



            <>
               <img
                src = {this.props.data && `http://openweathermap.org/img/wn/${this.props.data.weather[0].icon}@2x.png`}
                alt={this.props.data && "icon_meteo"}
              /> 
             {/* <p className="d-inline">
                {this.props.data && this.props.data.list[this.props.key].dt_txt}
              </p>  */}
  
            </>

        


  


    );
  }

}
export default ApiMeteoDay;
