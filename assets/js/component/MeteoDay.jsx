import React,{Component,Fragment} from 'react';
import MeteoHour from './MeteoHour';

class MeteoDay extends Component {

    constructor(props) {
        super(props);
        this.state = {
            showDays : false
        }


    }
    
    //show jours
    showDays = () =>{
    this.setState({
        showDays :!this.state.showDays
    })
    }    

    render() {
        return (

            <Fragment>
                <h5>{this.props.data && this.props.data.day_long}</h5>
                <img src={this.props.data && this.props.data.icon} alt=""/>
                {this.state.showDays ? <button onClick={this.showDays}>fermer</button> : <button onClick={this.showDays}>voir</button>}




        {this.state.showDays ? ["1H00","2H00","3H00","4H00","5H00","6H00","7H00","8H00","9H00","10H00","11H00","12H00","13H00","14H00","15H00","16H00","17H00","18H00",
        "19H00","20H00","21H00","22H00","23H00","24H00"].map(ele =>
                <MeteoHour key ={ele} imgH = {this.props.data && this.props.data.hourly_data[ele]}/>
                
                ) : ""}
                




            </Fragment>
            
        );
    }
}

export default MeteoDay;
