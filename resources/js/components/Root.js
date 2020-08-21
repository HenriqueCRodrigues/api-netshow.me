import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class Root extends Component {
    constructor(props) {
        super(props);
        
        this.state = {
            disable: false,
            message: '',
            auxFile: '',
            form: {
                name: '',
                email: '',
                message: '',
                file: '',
            },
            valid: {
                file: {classInput:'', classText: '', text: '', correct: false},
                message: {classInput:'', classText: '', text: '', correct: false},
                email: {classInput:'', classText: '', text: '', correct: false},
                name: {classInput:'', classText: '', text: '', correct: false},
            }, 
            utils: {
                email: {name: 'Email', regex: /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/, required: true},
                message: {name: 'Mensagem', regex: /./, required: true},
                name: {name: 'Nome', regex: /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/, required: true},
                file: {name: 'Arquivo', regex: /./, required: true}
            }
        };
    }

    onChange (e) {
        let id = e.target.id;
        let value = e.target.value;

        this.setState({
            form: {
                ...this.state.form,
                [id]: value,
            }
        });

        if (id == 'file') {
            this.setState({
                auxFile: e.target.files[0],
            });
        }

    }

    onBlur (e) {
        let id = e.target.id;
        let insert;
        let disable = false;

        if(this.state.utils[id].regex.test(this.state.form[id])) {
            insert = {[id]: {classInput:'is-valid', classText: 'valid', text: this.state.utils[id].name+' válido', correct: true}};
        } else {
            disable = true;
            insert = {[id]: {classInput:'is-invalid',  classText: 'invalid', text: this.state.utils[id].name+' inválido', correct: false}};
        }
    
        this.setState({
            disable: disable,
            valid: {
                ...this.state.valid,
                ...insert,
            }
        });

    }

    async onSubmit (e) {
        e.preventDefault();
        let valid = true;
        Object.keys(this.state.valid).forEach(item => {     
            if (!this.state.valid[item].correct && this.state.utils[item] && this.state.utils[item].required) {
                this.onBlur({target: {id: item}})
                valid = false;
            }
        }, valid);

        if (valid) {
            let form = new FormData();
            let disable = true;
            let message = '';

            this.setState({
                disable: disable
            });

            Object.keys(this.state.form).forEach(item => {  
                form.append(item, this.state.form[item])
            });

            form.append('file', this.state.auxFile);

            let insert = [];
            const option = {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: form,  
            };
            const call = await fetch(`api/contact`, option);
            const response = await call.json();
           
            if (call.status == 200) {
                message = 'O seu contato foi salvo na nossa base de dados';
            } else if (call.status == 422) {
                Object.keys(response.errors).forEach(item => {  
                    insert[item] = {classInput:'is-invalid',  classText: 'invalid', text: response.errors[item][0], correct: false};
                }, insert);
            } else {
                alert(response.data)
            }


            this.setState({
                message: message,
                disable: disable,
                valid: {
                    ...this.state.valid,
                    ...insert,
                }
            })
        }
    }

    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Contato</div>
                            <div className="card-body">
                                <form onSubmit={this.onSubmit.bind(this)}>
                                    <div className="form-group">
                                        <label htmlFor="exampleInputName">Nome</label>
                                        <input type="text" name="name" className={`form-control ${this.state.valid.name.classInput}`} id="name" aria-describedby="nameHelp" placeholder="Jose Benedito" value={this.state.form.name} onChange={this.onChange.bind(this)} onBlur={this.onBlur.bind(this)}/>
                                        <div className={this.state.valid.name.classText+"-feedback"}>
                                            {this.state.valid.name.text}
                                        </div>
                                    </div>

                                    <div className="form-group">
                                        <label htmlFor="exampleInputEmail1">Email</label>
                                        <input type="email" name="email" className={`form-control ${this.state.valid.email.classInput}`} id="email" aria-describedby="emailHelp" placeholder="email@email.com" value={this.state.form.email} onChange={this.onChange.bind(this)} onBlur={this.onBlur.bind(this)}/>
                                        <small id="emailHelp" className="form-text text-muted">Nunca iremos compartilhar seu email.</small>
                                        <div className={this.state.valid.email.classText+"-feedback"}>
                                            {this.state.valid.email.text}
                                        </div>
                                    </div>

                                    <div className="form-group">
                                        <label htmlFor="exampleInputEmail1">Mensagem</label>
                                        <textarea className={`form-control ${this.state.valid.message.classInput}`} id="message" aria-describedby="messageHelp" placeholder="Gostaria de dizer..." value={this.state.form.message} onChange={this.onChange.bind(this)} onBlur={this.onBlur.bind(this)}/>
                                        <small id="messageHelp" className="form-text text-muted">Descreva sua informação.</small>
                                        <div className={this.state.valid.message.classText+"-feedback"}>
                                            {this.state.valid.message.text}
                                        </div>
                                    </div>

                                    <div className="form-group">
                                        <label htmlFor="exampleInputFile1">File address</label>
                                        <input type="file" className={`form-control ${this.state.valid.file.classInput}`} id="file" aria-describedby="FileHelp" placeholder="Enter File" value={this.state.form.file} onChange={this.onChange.bind(this)} onBlur={this.onBlur.bind(this)}/>
                                        <div className={this.state.valid.file.classText+"-feedback"}>
                                            {this.state.valid.file.text}
                                        </div>
                                        <small id="FileHelp" className="form-text text-muted">Somente arquivos com extesões pdf, doc, docx, odt ou txt</small>
                                        <small id="FileHelp2" className="form-text text-muted">Arquivo até 500kb</small>
                                    </div>

                                    <div className="form-group">
                                        <input type="submit" className="btn-primary is-valid" value="Enviar" disabled={this.state.disable}/>
                                        <div className="valid-feedback">
                                                {this.state.message}
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

}

export default Root;

if (document.getElementById('root')) {
    ReactDOM.render(<Root />, document.getElementById('root'));
}
