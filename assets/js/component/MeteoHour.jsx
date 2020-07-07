import React,{Component,Fragment} from 'react';

class MeteoHour extends Component {

    render() {
        return (
            <Fragment>
                <img src={this.props.imgH && this.props.imgH.ICON} alt=""/> 
            </Fragment>
        );
    }
}

export default MeteoHour;