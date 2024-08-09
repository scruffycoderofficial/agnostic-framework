import { UsersUseCase } from "../usecases/UsersUseCase";
import {inject} from "inversify";

export class UsersController {
    constructor(@inject(UsersUseCase) private userUseCase: UsersUseCase) {
    }

    async getUsers(){
        const users = this.userUseCase.getUsers();
        return JSON.stringify(users);
    }
}