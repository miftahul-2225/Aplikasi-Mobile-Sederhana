declare module "@/api" {
  export function getUsers(): Promise<any>;
  export function getUserById(id: number): Promise<any>;
  export function addUser(data: any): Promise<any>;
  export function updateUser(id: number, data: any): Promise<any>;
  export function deleteUser(id: number): Promise<any>;
}
