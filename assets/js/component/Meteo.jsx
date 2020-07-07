import React, { Component } from 'react';


class Meteo extends Component {
    constructor(props) {

        super(props);
        this.state = {
            inputContent : '',
            lastResponse:''
        };
    }

    callApi = () =>{
        this.setState({loading:true})

        fetch(`https://www.prevision-meteo.ch/services/json/rieumes`)
        .then(res => res.json())
        .then(
        (result) => {

            this.setState({
            lastResponse:result,
            inputContent:''
            });
        },
        (error) => {
            console.log(error);
        });
    }

    componentDidMount(){
        this.callApi();
    }

    clickSubmit = (e) => {

        e.preventDefault();

        fetch(`https://www.prevision-meteo.ch/services/json/${this.state.inputContent}`)
        .then(res => res.json())
        .then(

        (result) => {
            if(result.errors){

                this.callApi();
                alert('Cette ville n\'existe pas');

            }else{

                console.log(result)
                    this.setState({
                        lastResponse:result,
                        inputContent:''
                    });
            }
        });
    }

    handleInputChange = (e)=> {
        const value = e.target.value;
        this.setState({
            inputContent : value
        })
    }


    render() {

        return (

        <div className="p-4 m-3">

            <div className="form-group">
                <label for="exampleInputPassword1">Saisissez une ville:</label>
                <input className="form-control" type="text" onChange={this.handleInputChange} />
                <button className="btn btn-secondary" onClick={this.clickSubmit}>Envoyer</button>

            </div>


            <h3 className='text-center'> Meteo {this.state.lastResponse && this.state.lastResponse.city_info && this.state.lastResponse.city_info.name}</h3>
            <img src={this.state.lastResponse && this.state.lastResponse.fcst_day_0 &&  this.state.lastResponse.fcst_day_0.icon_big}  
            className="rounded mx-auto d-block" style={{width: "150px"}}alt="icon_meteo"/>

        </div>


        );
    }
}

export default Meteo;
