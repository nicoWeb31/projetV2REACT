import React, { Component } from 'react';
import ApiMeteoDay from './ApiMeteoDay'



class ApiMeteo extends Component {
    constructor(props) {
        super(props);
        this.state = {
            ville : '',
            loading:false,
            error:'',
            lastResponse:null
        };
    }


    handleInputChange = (e) =>{
        const fieldName = e.target.name;
        const fieldValue = e.target.value;
        this.setState({
            [fieldName] : fieldValue
        })
    }


    clickSubmit = (e) => {

        e.preventDefault();
        const url = "https://www.prevision-meteo.ch/services/json/";
        this.setState({loading:true})

        fetch(url + this.state.ville)
        .then(res => res.json())
        .then(
        (result) => {
        //console.log(result)
            this.setState({
            loading:false,
            lastResponse:result,
            ville:''
             
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


    render() {

        return (
            <div>
                <div className="form-group">
        <label className="text-center h5 pt-4" >Meteo : {this.state.ville}</label>
                <input type="text" className='form-control ' onChange={this.handleInputChange} name="ville" value = {this.state.ville}/>

                <button onClick={this.clickSubmit} className='btn btn-raised btn-primary m-3 p-3 mx-auto d-block'>Envoyer</button>
                </div>
                 {this.state.loading ? (
                    <div className="spinner-border mx-auto" role="status">
                    <span className="sr-only mx-auto">Loading...</span>
                  </div>
                ):
                (
                    ["fcst_day_0","fcst_day_1","fcst_day_2","fcst_day_3"].map(ele =>
                        <ApiMeteoDay  key ={ele} data={this.state.lastResponse && this.state.lastResponse[ele]}/>
                    )
                )} 
            </div>
        );
    }
}

export default ApiMeteo;