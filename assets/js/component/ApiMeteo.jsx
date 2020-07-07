import React, { Component } from 'react';


class ApiMeteo extends Component {
    constructor(props) {
        super(props);
        this.state = {
            //ville : '',
            loading:false,
            error:'',
            lastResponse:null
        };
    }


    componentDidMount(){

        const keyApi = '27d544efcc1c6328b73d495da2d3a53a'
        this.setState({loading:true})

        fetch(`https://api.openweathermap.org/data/2.5/forecast?q=rieumes&appid=${keyApi}&lang=fr`)
        .then(res => res.json())
        .then(
        (result) => {
        console.log(result)
            this.setState({
            loading:false,
            lastResponse:result,
            //ville:''
             
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



    handleInputChange = (e) =>{
        const fieldName = e.target.name;
        const fieldValue = e.target.value;
        this.setState({
            [fieldName] : fieldValue
        })
    }


    clickSubmit = (e) => {

        e.preventDefault();
        const keyApi = '27d544efcc1c6328b73d495da2d3a53a'
        this.setState({loading:true})

        fetch(`https://api.openweathermap.org/data/2.5/forecast?q=${this.state.ville}&appid=${keyApi}&lang=fr`)
        .then(res => res.json())
        .then(
        (result) => {
        console.log(result)
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

        console.log(this.state.lastResponse && this.state.lastResponse)
        console.log(this.state.lastResponse && this.state.lastResponse.list[0])


        return (
        //     <>
        //         <div className="form-group">
        // <label className="text-center h5 pt-4" >Meteo : {this.state.ville}</label>
        //         <input type="text" className='form-control ' onChange={this.handleInputChange} name="ville" value = {this.state.ville}/>

        //         <button onClick={this.clickSubmit} className='btn btn-raised btn-primary m-3 p-3 mx-auto d-block'>Envoyer</button>
        //         </div>
        //         {this.state.loading ? (
        //             <div className="spinner-border mx-auto" role="status">
        //             <span className="sr-only mx-auto">Loading...</span>
        //         </div>
        //         ):
        //         (
        //             // <div className=" d-flex justify-content-around ">

        //                 [2,8,16,24,32,39].map((ele,index) =>
    
        //                         <ApiMeteoDay key={index}   data={this.state.lastResponse && this.state.lastResponse.list[ele]} />
    
        //                 )

        //             // </div>

        //         )} 
        //     </>



        <div className="p-4 m-3">
            <h3 className='text-center'> Meteo {this.state.lastResponse && this.state.lastResponse.city.name}</h3>
            <img src={this.state.lastResponse && `http://openweathermap.org/img/wn/${this.state.lastResponse.list[0].weather[0].icon}@2x.png`}  className="rounded mx-auto d-block" style={{width: "150px"}}alt="..."/>
            <p className='text-center' >{this.state.lastResponse && this.state.lastResponse.list[0].weather[0].description}</p>
        </div>


        );
    }
}

export default ApiMeteo;