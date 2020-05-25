import React,{Component} from 'react';



class ApiMeteoDay extends Component {

    constructor(props) {
        super(props);
        this.state = {
        }


    }
    

    render() {
        return (

          
          <div className = "d-flex justify-content-around">


                      <img src={this.props.data && this.props.data.icon} alt={this.props.data && "icon_meteo"}/>
                      <p className="d-inline">{this.props.data && this.props.data.day_long}</p>

                    

                    </div>
            
            

            );      




            
    }
}

export default ApiMeteoDay;