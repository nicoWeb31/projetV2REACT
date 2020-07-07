import React, { Component } from 'react';
import ApiMeteoDay from './ApiMeteoDay';




class ApiMeteo extends Component {
    constructor(props) {
        super(props);
        this.state = {
            inputContent : '',
            loading:false,
            error:'',
            lastResponse:''
        };
    }


    callApi = () =>{

        this.setState({loading:true})

        fetch(`https://www.prevision-meteo.ch/services/json/rieumes`)
        .then(res => res.json())
        .then(
        (result) => {
        console.log(result)
            this.setState({
            loading:false,
            lastResponse:result,
            inputContent:''
            });
        },
        (error) => {
            console.log(error);
            this.setState({
            error
            });
        }
        )


    }



    componentDidMount(){

    this.callApi();

    }


    co

    clickSubmit = (e) => {

        e.preventDefault();
        this.setState({loading:true})

        fetch(`https://www.prevision-meteo.ch/services/json/${this.state.inputContent}`)
        .then(res => res.json())
        .then(

        (result) => {

            if(result.errors){

                console.log('toto');
                this.callApi();
                alert('Cette ville n\'existe pas');

            }else{

                console.log(result)
                    this.setState({
                    loading:false,
                    lastResponse:result,
                    inputContent:''
        
                    });
            }
        },
        )



    }

    handleInputChange =(event)=> {
        const value = event.target.value;
        console.log(value);
        this.setState({
            inputContent : value
        })
    }


    render() {

        console.log(this.state.lastResponse && this.state.lastResponse)



        return (


        <div className="p-4 m-3">

            <div className="form-group">
                <label for="exampleInputPassword1">Saisissez une ville:</label>
                <input className="form-control" type="text" onChange={this.handleInputChange} />
                <button className="btn btn-secondary" onClick={this.clickSubmit}>Envoyer</button>

            </div>


            <h3 className='text-center'> Meteo {this.state.lastResponse && this.state.lastResponse.city_info && this.state.lastResponse.city_info.name}</h3>
            <img src={this.state.lastResponse && this.state.lastResponse.fcst_day_0 &&  this.state.lastResponse.fcst_day_0.icon_big}  className="rounded mx-auto d-block" style={{width: "150px"}}alt="iconMeteo"/>
            {/* <p className='text-center' >{this.state.lastResponse && this.state.lastResponse.list[0].weather[0].description}</p> */}
        </div>


        );
    }
}

export default ApiMeteo;
